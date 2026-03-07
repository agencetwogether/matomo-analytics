<?php

namespace Agencetwogether\MatomoAnalytics\Support;

use Agencetwogether\MatomoAnalytics\Traits\MetricDiff;
use Carbon\Carbon;

class MatomoDateResolver
{
    use MetricDiff;

    public static function resolve(string $filter, bool $hasPeriod): array
    {
        $lastWeek = self::getLastWeek();
        $lastMonth = self::getLastMonth();
        $lastSevenDays = self::getLastSevenDays();
        $lastThirtyDays = self::getLastThirtyDays();

        return match ($filter) {

            'today' => [
                'period' => 'day',
                'date' => $hasPeriod ? Carbon::yesterday()->format('Y-m-d') . ',' . Carbon::today()->format('Y-m-d') : 'today',
            ],

            'yesterday' => [
                'period' => 'day',
                'date' => $hasPeriod ? Carbon::yesterday()->clone()->subDay()->format('Y-m-d') . ',' . Carbon::yesterday()->format('Y-m-d') : 'yesterday',
            ],

            'last_7_days' => [
                'period' => 'day',
                'date' => $hasPeriod ? "{$lastSevenDays['previous']->start->format('Y-m-d')},{$lastSevenDays['current']->end->format('Y-m-d')}" : 'last7',
            ],

            'last_30_days' => [
                'period' => 'day',
                'date' => $hasPeriod ? "{$lastThirtyDays['previous']->start->format('Y-m-d')},{$lastThirtyDays['current']->end->format('Y-m-d')}" : 'last30',
            ],

            'last_week' => [
                'period' => 'week',
                'date' => $hasPeriod ? "{$lastWeek['previous']->end->format('Y-m-d')},{$lastWeek['current']->end->format('Y-m-d')}" : 'lastWeek',
            ],

            'last_month' => [
                'period' => 'month',
                'date' => $hasPeriod ? "{$lastMonth['previous']->end->format('Y-m-d')},{$lastMonth['current']->end->format('Y-m-d')}" : 'lastMonth',
            ],

            'this_week' => [
                'period' => 'week',
                'date' => 'today',
            ],
            'this_month' => [
                'period' => 'month',
                'date' => 'today',
            ],
            'this_year' => [
                'period' => 'year',
                'date' => 'today',
            ],

            default => [
                'period' => 'day',
                'date' => 'today',
            ],
        };
    }
}
