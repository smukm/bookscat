<?php

declare(strict_types=1);

if(!function_exists('iniGetSize')) {
    function iniGetSize(string $name): int
    {
        $size = ini_get($name) ?: '0';

        return convertToBytes($size);
    }
}

if(!function_exists('convertToBytes')) {
    function convertToBytes(string $from): ?int
    {
        $suffixes = ['B', 'K', 'M', 'G', 'T', 'P'];
        $number = substr($from, 0, -1);
        $suffix = strtoupper(substr($from, -1));

        if (is_numeric($suffix)) {
            return (int)preg_replace('/\D/', '', $from);
        }

        $exponent = array_search($suffix, $suffixes);

        if ($exponent === false) {
            return null;
        }

        return $number * (1024 ** $exponent);
    }
}

if(!function_exists('printFileSize')) {
    function printFileSize(int $file_size): string
    {
        return match (true) {
            ($file_size >= 1125899906842624) => (round($file_size / 1125899906842624 * 100) / 100) . ' Пб.',
            ($file_size >= 1099511627776) => (round($file_size / 1099511627776 * 100) / 100) . ' Тб.',
            ($file_size >= 1073741824) => (round($file_size / 1073741824 * 100) / 100) . ' Гб.',
            ($file_size >= 1048576) => (round($file_size / 1048576 * 100) / 100) . ' Мб.',
            ($file_size >= 1024) => (round($file_size / 1024 * 100) / 100) . ' Кб.',
            ($file_size < 1024) => $file_size .= ' Байт'
        };
    }
}