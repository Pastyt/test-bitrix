<?php

namespace Currency\Main;

class AgentRunner
{
    private const AGENT_FUNCTION = '\\Currency\\Main\\AgentRunner::runDailyUpdate();';

    public static function runDailyUpdate(): string
    {
        CurrencyUpdate::dailyUpdate(new CbrFetcher);
        return self::AGENT_FUNCTION;
    }

    public static function getFunction(): string
    {
        return self::AGENT_FUNCTION;
    }
}