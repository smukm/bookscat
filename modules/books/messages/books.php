<?php

declare(strict_types=1);

return [
    'sourcePath' => dirname(__DIR__),
    'messagePath' => __DIR__,
    'languages' => ['en', 'ru'],
    'translator' => 'Module::t',
    'sort' => false,
    'overwrite' => true,
    'removeUnused' => true,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/migrations'
    ],
    'format' => 'php',
];
