<?php

declare(strict_types=1);

namespace unit;

use Codeception\Test\Unit;

class HelpersTest extends Unit
{

    public function testConvertToBytes()
    {
        $from = ['32b', '32k', '32m', '32G', '32T', '32P', '32', '32X'];

        $res = array_map(function ($v) {
            return convertToBytes($v);
        }, $from);

        $this->assertEquals([
            0 => 32,
            1 => 32768,
            2 => 33554432,
            3 => 34359738368,
            4 => 35184372088832,
            5 => 36028797018963968,
            6 => 32,
            7 => null
        ], $res);
    }

    public function testIniGetSize()
    {
        $this->assertEquals(0, iniGetSize('wrong_key'));
    }

    public function testPrintFileSize()
    {
        $from = [
            32,
            32768,
            33554432,
            34359738368,
            35184372088832,
            36028797018963968,
        ];

        $res = array_map(function ($v) {
            return printFileSize($v);
        }, $from);

        $this->assertEquals([
            0 => '32 Байт',
            1 => '32 Кб.',
            2 => '32 Мб.',
            3 => '32 Гб.',
            4 => '32 Тб.',
            5 => '32 Пб.',
        ], $res);
    }
}
