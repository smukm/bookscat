<?php

declare(strict_types=1);

namespace modules\books\services;

use DomainException;
use modules\books\entities\Subscriber;
use modules\books\forms\SubscribeForm;
use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;

class SubscribeService
{
    /**
     * @throws Exception
     */
    public function subscribe(SubscribeForm $subscribeForm): void
    {
        $authors = explode(';', $subscribeForm->author_ids);

        foreach ($authors as $author_id) {
            $subscriber = Subscriber::find()
                ->where(['author_id' => $author_id])
                ->andWhere(['phone' => $subscribeForm->phone])
                ->one();

            if(!$subscriber) {
                $subscriber = Subscriber::create((int)$author_id, $subscribeForm->phone);
                if(!$subscriber->save()) {
                    throw new DomainException('Unable to subscribe');
                }
            }
        }
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function unsubscribe(SubscribeForm $subscribeForm): void
    {
        $authors = explode(';', $subscribeForm->author_ids);

        foreach ($authors as $author_id) {
            $subscriber = Subscriber::find()
                ->where(['author_id'=> $author_id])
                ->andWhere(['phone' => $subscribeForm->phone])
                ->one();

            if($subscriber) {
                if($subscriber->delete() === false) {
                    throw new DomainException('Unable to unsubscribe');
                }
            }
        }
    }
}