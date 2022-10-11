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

            $new_currency = CurrencyTable::createObject();
            $new_currency->setCode($currency['code']);
            $new_currency->setDate($currency['date']);
            $new_currency->setCourse($currency['course']);
            $collection->add($new_currency);
        }

        $collection->save();
    }
}