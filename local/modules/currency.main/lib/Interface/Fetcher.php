<?php

namespace Currency\Main\Interface;

use JetBrains\PhpStorm\ArrayShape;

interface Fetcher
{
    /**
     * @return array each element has [code, course, date]
     */
    public static function fetchCurrency(): array;
}