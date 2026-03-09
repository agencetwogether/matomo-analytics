<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait MetricDiff
{
    /** @return array{current: CarbonPeriod, previous: CarbonPeriod} */
    private static function getLastWeek(): array
    {
        $current = CarbonPeriod::create(
            Carbon::today()
                ->clone()
                ->startOfWeek(Carbon::SUNDAY)
                ->subWeek(),
            Carbon::today()
                ->clone()
                ->subWeek()
                ->endOfWeek(Carbon::SATURDAY)
        );

        $previous = CarbonPeriod::create(
            Carbon::today()
                ->clone()
                ->startOfWeek(Carbon::SUNDAY)
                ->subWeeks(2),
            Carbon::today()
                ->clone()
                ->subWeeks(2)
                ->endOfWeek(Carbon::SATURDAY)
        );

        return [
            'current' => $current,
            'previous' => $previous,
        ];
    }

    /** @return array{current: CarbonPeriod, previous: CarbonPeriod} */
    private static function getLastMonth(): array
    {
        $current = CarbonPeriod::create(
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonth(),
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonth()
                ->endOfMonth()
        );

        $previous = CarbonPeriod::create(
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonths(2),
            Carbon::today()
                ->clone()
                ->startOfMonth()
                ->subMonths(2)
                ->endOfMonth()
        );

        return [
            'current' => $current,
            'previous' => $previous,
        ];
    }

    /** @return array{current: CarbonPeriod, previous: CarbonPeriod} */
    private static function getLastSevenDays(): array
    {
        $current = CarbonPeriod::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(6),
            Carbon::yesterday()
        );

        $previous = CarbonPeriod::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(13),
            Carbon::yesterday()
                ->clone()
                ->subDays(7)
        );

        return [
            'current' => $current,
            'previous' => $previous,
        ];
    }

    /** @return array{current: CarbonPeriod, previous: CarbonPeriod} */
    private static function getLastThirtyDays(): array
    {
        $current = CarbonPeriod::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(29),
            Carbon::yesterday()
        );

        $previous = CarbonPeriod::create(
            Carbon::yesterday()
                ->clone()
                ->subDays(59),
            Carbon::yesterday()
                ->clone()
                ->subDays(30)
        );

        return [
            'current' => $current,
            'previous' => $previous,
        ];
    }
}
