<?php

namespace Currency\Main;

use Bitrix\Main\Type\Date;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Web\Uri;
use CDataXML;
use Currency\Main\Interface\Fetcher;

class CbrFetcher implements Fetcher
{
    private const SOURCE_URL = 'http://www.cbr.ru/scripts/XML_daily.asp';

    public static function fetchCurrency(): array
    {
        if (!$request = self::sendRequest()) {
            return [];
        }

        $currencies = self::xmlToArray($request);

        return self::formatCurrencies($currencies);
    }

    private static function sendRequest(): string
    {
        if ($result = (new HttpClient())->get(self::compileUri())) {
            return $result;
        }

        return '';
    }

    private static function compileUri(): string
    {
        return (new Uri(self::SOURCE_URL))->addParams(['date_req' => (new Date())->format('d/m/Y')])->getUri();
    }

    private static function xmlToArray(string $request): array
    {
        $xml = new CDataXML();
        $xml->LoadString($request);

        return $xml->GetArray();
    }

    private static function formatCurrencies(array $currencies): array
    {
        $formatted_cur = [];
        $date = $currencies['ValCurs']['@']['Date'];

        foreach ($currencies['ValCurs']['#']['Valute'] as $currency) {

            $currency = $currency['#'];

            $formatted_cur[] = [
              'code' => $currency['CharCode'][0]['#'],
              'course' => (float)str_replace(',', '.', $currency['Value'][0]['#']),
              'date' => $date,
            ];
        }

        return $formatted_cur;
    }
}