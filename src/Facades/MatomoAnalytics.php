<?php

namespace Agencetwogether\MatomoAnalytics\Facades;

use Agencetwogether\MatomoAnalytics\MatomoAnalytics as FilamentMatomoAnalytics;
use Illuminate\Support\Facades\Facade;

/**
 * @method static thousandsFormater()
 * @method static for()
 *
 * @see \Agencetwogether\MatomoAnalytics\MatomoAnalytics
 */
class MatomoAnalytics extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FilamentMatomoAnalytics::class;
    }
}
