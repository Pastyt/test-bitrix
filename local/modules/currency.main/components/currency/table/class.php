<?php

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Main\Web\Uri;
use Currency\Main\Table\CurrencyTable;

Loader::includeModule('currency.main');

class Table extends CBitrixComponent
{
    private const SORT_FIELDS = ['code', 'date', 'course'];
    private const ACCEPT_SORT_VAL = ['asc','desc'];

    private array $activeSort = [];
    private int $page = 1;
    /** @var int Кол-во выводимых элементов */
    private int $count = 10;

    private function getElements(): array
    {
        $currencies = CurrencyTable::getList(
            [
                'order'       => $this->activeSort,
                'limit'       => $this->count,
                'select'      => ['code', 'date', 'course'],
                'offset'      => ($this->page - 1) * $this->count,
                'count_total' => true
            ]
        )->fetchCollection();

        $currencies_result = [];

        foreach ($currencies as $currency) {
            $currencies_result[] = [
                'code'   => $currency->getCode(),
                'date'   => $currency->getDate()->format('d.m.Y'),
                'course' => $currency->getCourse()
            ];
        }

        return $currencies_result;
    }

    public function executeComponent()
    {
        /**
         * $arParams count, code/date/course = asc/desc,
         */
        $this->checkRequest();

        $this->arResult = [
            'currencies' => $this->getElements(),
            'pagination' => $this->getPagination(),
            'sort'       => $this->getSort(),
        ];


        $this->includeComponentTemplate();
    }

    /** Получение GET параметров и их установка */
    private function checkRequest(): void
    {
        $request = Context::getCurrent()->getRequest();

        foreach (self::SORT_FIELDS as $field) {
            if (($value = $request->get($field)) && in_array($value, self::ACCEPT_SORT_VAL, true)) {
                $this->activeSort[$field] = $value;
            }
        }

        if ($this->arParams['count']) {
            $this->count = $this->arParams['count'];
        }


        if ((int)$request->get('page')) {
            $this->page = (int)$request->get('page');
        }
    }

    private function getPagination(): array
    {
        $total = CurrencyTable::getList(['count_total' => true])->getCount();

        $pages = (int)ceil($total / $this->count);

        $pagination = [];

        foreach (range(1, $pages) as $number) {
            if ($number === $this->page) {
                $pagination[] = ['page' => $number];
            } else {
                $pagination[] = [
                    'page' => $number,
                    'link' => (new Uri(''))->addParams(['page' => $number,] + $this->activeSort)->getUri()
                ];
            }
        }

        return $pagination;
    }

    private function getSort(): array
    {
        $sort_link = [];

        foreach (self::SORT_FIELDS as $field) {
            $active_sort = $this->activeSort;

            if ($active_sort[$field]) {
                /** [asc, desc] - [asc] = [desc] */
                $active_sort[$field] = array_values(array_diff(self::ACCEPT_SORT_VAL, [$active_sort[$field]]))[0];
            } else {
                $active_sort += [$field => 'asc'];
            }

            $sort_link[$field] = (new Uri(''))->addParams(['page' => $this->page] + $active_sort)->getUri();
        }

        return $sort_link;
    }


}