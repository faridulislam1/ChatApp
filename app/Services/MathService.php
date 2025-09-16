<?php

namespace App\Services;

class MathService
{
    public function add($a, $b)
    {
        return $a + $b;
    }

    public function subtract($a, $b)
    {
        return $a - $b;
    }

    public function multiply($a, $b)
    {
        return $a * $b;
    }

    public function divide($a, $b)
    {
        if ($b == 0) {
            throw new \Exception("Division by zero is not allowed.");
        }
        return $a / $b;
    }

    public function average(array $numbers)
    {
        return array_sum($numbers) / count($numbers);
    }

    public function power($base, $exp)
    {
        return pow($base, $exp);
    }

    public function percentage($total, $part)
    {
        return ($part / $total) * 100;
    }
}
