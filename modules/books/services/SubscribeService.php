<?php

namespace modules\books\services;

use DomainException;
use modules\books\entities\Subscriber;
use modules\books\forms\SubscribeForm;
use yii\db\Exception;
use yii\db\StaleObjectException;

class SubscribeService
{
    /**
     * @throws Exception
     */
    public function subscribe(SubscribeForm $subscribeForm): bool
    {
        $subscriber = Subscriber::find()
            ->where(['author_id'=> $subscribeForm->author_id])
            ->andWhere(['phone' => $subscribeForm->phone])
            ->one();

        if(!$subscriber) {
            $subscriber = Subscriber::create($subscribeForm->author_id, $subscribeForm->phone);
            if(!$subscriber->save()) {
                throw new DomainException('Unable to subscribe');
            }
            return true;
        }

        return false;
    }

    /**
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function unsubscribe(SubscribeForm $subscribeForm): bool
    {
        $subscriber = Subscriber::find()
            ->where(['author_id'=> $subscribeForm->author_id])
            ->andWhere(['phone' => $subscribeForm->phone])
            ->one();

        if($subscriber) {
            if($subscriber->delete() === false) {
                throw new DomainException('Unable to unsubscribe');
            }
            return true;
        }

        return false;
    }
}