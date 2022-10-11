<?php

namespace Currency\Main;

use Currency\Main\Interface\Fetcher;
use Currency\Main\Table\CurrencyTable;

class CurrencyUpdate
{
    public static function dailyUpdate(Fetcher $fetcher): void
    {
        $collection = CurrencyTable::createCollection();

        foreach ($fetcher::fetchCurrency() as $currency) {

            self::deleteDuplicates($currency['code'], $currency['date']);

            $new_currency = CurrencyTable::createObject();
            $new_currency->setCode($currency['code']);
            $new_currency->setDate($currency['date']);
            $new_currency->setCourse($currency['course']);
            $collection->add($new_currency);
        }

        $collection->save();
    }

    private static function deleteDuplicates(string $code, string $date): void
    {
        $duplicates = CurrencyTable::getList(['filter' => ['code' => $code, 'date' => $date]])->fetchCollection();

        foreach ($duplicates as $duplicate) {
            $duplicate->delete();
        }
    }
}