<?php

namespace modules\books\contracts;

use modules\books\entities\Book;

interface SubscribeNotifyContract
{
    public function send(array $subscribers, Book $book): void;
}