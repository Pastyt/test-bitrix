<?php

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Currency\Main\Table\CurrencyTable;

Loader::includeModule('currency.main');

class Table extends CBitrixComponent
{
    private function getElements(): void
    {
        $order = [];

        foreach (['code', 'date', 'course'] as $field) {
            if (($value = $this->arParams[$field]) && in_array($value, ['asc', 'desc'])) {
                $order[$field] = $value;
            }
        }

        if (!$page = $this->arParams['page']) {
            $page = 1;
        }
        $elements = $this->arParams['count'];

        $offset = ($page - 1) * $elements;

        $currencies = CurrencyTable::getList(
            ['order'       => $order,
             'limit'       => $elements,
             'select'      => ['code', 'date', 'course'],
             'offset'      => $offset,
             'count_total' => true
            ]
        )->fetchCollection();

        $currencies_result = [];

        foreach ($currencies as $currency) {
            $currencies_result[] = [
                'code'   => $currency->getCode(),
                'date'   => $currency->getDate()->toString(),
                'course' => $currency->getCourse()
            ];
        }

        $this->arResult['currencies'] = $currencies_result;
    }

    public function executeComponent()
    {
        /**
         * $arParams count, code/date/course = asc/desc,
         */
        $this->checkRequest();
        $this->getElements();
        $this->getPagination();

        $this->includeComponentTemplate();
    }

    private function checkRequest(): void
    {
        $request = Context::getCurrent()->getRequest();

        foreach (['code', 'date', 'course', 'page'] as $field) {
            if ($value = $request->get($field)) {
                $this->arParams[$field] = $value;
            }
        }

        if (!$this->arParams['count']) {
            $this->arParams['count'] = 10;
        }
    }

    private function getPagination(): void
    {
        $order_string = '';

        foreach (['code', 'date', 'course'] as $field) {
            if (($value = $this->arParams[$field]) && in_array($value, ['asc', 'desc'])) {
                $order_string .= "&$field=$value";
            }
        }

        if (!$page = $this->arParams['page']) {
            $page = 1;
        }
        $elements = $this->arParams['count'];

        $total = CurrencyTable::getList(['count_total' => true])->getCount();

        $pages = (int)ceil($total / $elements);

        $pagination = [];

        foreach (range(1, $pages) as $number) {
            if ($number == $page) {
                $pagination[] = ['page' => $number];
            } else {
                $pagination[] = ['page' => $number, 'link' => "?page=$number$order_string"];
            }
        }

        $this->arResult['pagination'] = $pagination;
    }
}