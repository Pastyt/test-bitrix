<?php

namespace Currency\Main;

class AgentRunner
{
    public static function runDailyUpdate(): void
    {
        \Currency\Main\CurrencyUpdate::dailyUpdate(new \Currency\Main\CbrFetcher);
    }
}