<?php

use PHPUnit\Framework\TestCase;
use App\Fraction;

class FractionTests extends TestCase
{
    public function test_fraction_denominaror_isReal() {
        $number = new Fraction(7, 8);
        $denomenator = $number->getDenom();
        self::assertEquals($denomenator, 8);
    }

    public function test_fraction_numerator_isReal() {
        $number = new Fraction(14, 99);
        $numerator = $number->getNumer();
        self::assertEquals($numerator, 14);
    }

    public function test_fraction_toString_isReal() {
        $number = new Fraction(1, 4);
        $test_number = new Fraction(1, 2);
        $result = $number->add($test_number)->__toString();
        $real_result = '3/4';
        self::assertEquals($result, $real_result);
    }

    public function test_fraction_sub_isReal() {
        $number = new Fraction(50, 100);
        $test_number = new Fraction(20, 100);
        $result = $number->sub($test_number)->__toString();
        $real_result = '3/10';
        self::assertEquals($result, $real_result);
    }
} 