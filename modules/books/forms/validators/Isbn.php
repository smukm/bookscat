<?php

declare(strict_types=1);

namespace modules\books\forms\validators;

class Isbn
{
    public function __invoke(string $isbn): bool
    {
        $isbn = preg_replace('#\D#', '', $isbn);

        $isValid = false;

        if(strlen($isbn) === 10) {
            $isValid = $this->check10Isbn($isbn);
        } elseif((strlen($isbn) === 13)) {
            $isValid = $this->check13Isbn($isbn);
        }

        return $isValid;
    }

    private function check10Isbn(string $isbn): bool
    {
        $digits = str_split($isbn);

        $sum = 0;

        foreach ($digits as $index => $digit) {

            $sum += ($index + 1) * (int)$digit;
        }

        return ($sum % 11) === 0;
    }

    private function check13Isbn(string $isbn): bool
    {
        $digits = str_split($isbn);

        $check = 0;
        for ($i = 0; $i < 13; $i += 2) {
            $check += (int)$digits[$i];
        }

        for ($i = 1; $i < 12; $i += 2) {
            $check += 3 * $digits[$i];
        }

        return ($check % 10) === 0;
    }
}