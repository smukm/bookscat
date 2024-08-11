<?php
if(!function_exists('ini_get_size')) {
    function ini_get_size(string $name): int
    {
        $size = ini_get($name);
        $unit = substr($size, -1);
        $iSize = (int) substr($size, 0, -1);

        switch (strtoupper($unit))
        {
            case 'Y' : $iSize *= 1024; // Yotta
            case 'Z' : $iSize *= 1024; // Zetta
            case 'E' : $iSize *= 1024; // Exa
            case 'P' : $iSize *= 1024; // Peta
            case 'T' : $iSize *= 1024; // Tera
            case 'G' : $iSize *= 1024; // Giga
            case 'M' : $iSize *= 1024; // Mega
            case 'K' : $iSize *= 1024; // kilo
        }

        return $iSize;
    }
}

if(!function_exists('print_file_size')) {
    function print_file_size(int $file_size): string
    {
        if ($file_size >= 1073741824) {
            $file_size = (round($file_size / 1073741824 * 100) / 100) . " Гб.";
        } elseif ($file_size >= 1048576) {
            $file_size = (round($file_size / 1048576 * 100) / 100) . " Мб.";
        } elseif ($file_size >= 1024) {
            $file_size = (round($file_size / 1024 * 100) / 100) . " Кб.";
        } else {
            $file_size .= " Байт";
        }

        return $file_size;
    }
}