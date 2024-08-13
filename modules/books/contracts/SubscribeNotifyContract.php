<?php

declare(strict_types=1);

namespace modules\books\contracts;

use modules\books\entities\Book;

interface SubscribeNotifyContract
{
    public function send(array $subscribers, Book $book): void;
}