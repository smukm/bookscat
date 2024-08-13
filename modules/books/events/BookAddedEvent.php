<?php

declare(strict_types=1);

namespace modules\books\events;

use modules\books\entities\Book;

class BookAddedEvent extends Event
{

    public function __construct(
        public Book $book
    )
    {
    }
}