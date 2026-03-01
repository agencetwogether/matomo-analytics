<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use BernskioldMedia\LaravelMatomo\Facades\Matomo;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait Visitors
{
    use MetricDiff;

    /** @return array{result: int, previous: int} */
    private function visitorsToday(): array
    {
        $period = CarbonPeriod::create(Carbon::yesterday(), Carbon::today());

        $results = collect(Matomo::summary()->site(config('matomo-analytics.id_site'))->between($period->start, $period->end)->uniqueVisitors());

        return [
            'result' => (int) ($results->last() ?? 0),
            'previous' => (int) ($results->first() ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitorsYesterday(): array
    {
        $period = CarbonPeriod::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday());

        $results = collect(Matomo::summary()->site(config('matomo-analytics.id_site'))->between($period->start, $period->end)->uniqueVisitors());

        return [
            'result' => (int) ($results->last() ?? 0),
            'previous' => (int) ($results->first() ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitorsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();

        $results = collect(Matomo::summary()->site(config('matomo-analytics.id_site'))->period('week')->date("{$lastWeek['previous']->end->format('Y-m-d')},{$lastWeek['current']->end->format('Y-m-d')}")->uniqueVisitors());

        return [
            'previous' => (int) ($results->first() ?? 0),
            'result' => (int) ($results->last() ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitorsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();

        $results = collect(Matomo::summary()->site(config('matomo-analytics.id_site'))->period('month')->date("{$lastMonth['previous']->end->format('Y-m-d')},{$lastMonth['current']->end->format('Y-m-d')}")->uniqueVisitors());

        return [
            'previous' => (int) ($results->first() ?? 0),
            'result' => (int) ($results->last() ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitorsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();

        $results = collect(Matomo::summary()->site(config('matomo-analytics.id_site'))->period('day')->date("{$lastSevenDays['previous']->start->format('Y-m-d')},{$lastSevenDays['current']->end->format('Y-m-d')}")->uniqueVisitors());

        $position = 0;
        [$previous, $current] = $results->partition(function ($i) use ($results, &$position) {
            $position++;

            return $position <= $results->count() / 2;
        });

        return [
            'previous' => (int) ($previous->sum() ?? 0),
            'result' => (int) ($current->sum() ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitorsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();

        $results = collect(Matomo::summary()->site(config('matomo-analytics.id_site'))->period('day')->date("{$lastThirtyDays['previous']->start->format('Y-m-d')},{$lastThirtyDays['current']->end->format('Y-m-d')}")->uniqueVisitors());

        $position = 0;
        [$previous, $current] = $results->partition(function ($i) use ($results, &$position) {
            $position++;

            return $position <= $results->count() / 2;
        });

        return [
            'previous' => (int) ($previous->sum() ?? 0),
            'result' => (int) ($current->sum() ?? 0),
        ];
    }
}
