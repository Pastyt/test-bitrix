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
            /** bitrix just cant live without primary */
            'id' => new Entity\IntegerField('id', [
                'primary'      => true,
                'autocomplete' => true,
            ]),
            'code'   => new Entity\StringField('code'),
            'date'   => new Entity\DatetimeField('date'),
            'course' => new Entity\FloatField('course'),
        ];
    }
}

