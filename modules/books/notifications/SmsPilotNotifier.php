<?php

namespace modules\books\notifications;

use JetBrains\PhpStorm\NoReturn;
use modules\books\contracts\SubscribeNotifyContract;
use modules\books\entities\Book;
use Yii;

class SmsPilotNotifier implements SubscribeNotifyContract
{

    private const string API_KEY = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';
    #[NoReturn] #[\Override] public function send(array $subscribers, Book $book): void
    {
        if(!count($subscribers)) {
            return;
        }

        $text = 'We have a new book: ' . $book->title;

        $send = $this->composeSend($subscribers, $text);

        $result = file_get_contents('https://smspilot.ru/api2.php', false, stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode( $send ),
            ),
        )));

        $response = json_decode( $result );
        if (!isset($response->error)) {
            foreach($response->send as $info) {
                Yii::info('SMS успешно отправлена на номер ' . $info->to . ' server_id=' . $info->server_id);
            }
        } else {
            Yii::error($response->error->description_ru);
        }
    }

    private function composeSend(array $subscribers, string $text): array
    {
        $send = [
            'apikey' => self::API_KEY,
            'from' => 'INFORM',
        ];
        foreach ($subscribers as $idx => $phone) {
            $send['send'][] = [
                'id' => $idx + 1,
                'to' => $phone,
                'text' => $text,
            ];
        }

        return $send;
    }
}