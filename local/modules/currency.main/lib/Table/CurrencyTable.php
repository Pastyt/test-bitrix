<?php

namespace Currency\Main\Table;

use Bitrix\Main\SystemException;
use Bitrix\Main\Entity;

class CurrencyTable extends Entity\DataManager
{
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'currency_main';
    }

    /**
     * @return array
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            'code'   => new Entity\StringField('code', ['primary' => true,]),
            'date'   => new Entity\DatetimeField('date'),
            'course' => new Entity\FloatField('course'),
        ];
    }
}

