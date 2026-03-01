<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use BernskioldMedia\LaravelMatomo\Facades\Matomo;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait Visits
{
    use MetricDiff;

    /** @return array{result: int, previous: int} */
    private function visitsToday(): array
    {
        $period = CarbonPeriod::create(Carbon::yesterday(), Carbon::today());

        $results = collect(Matomo::summary()->site(config('matomo-analytics.id_site'))->between($period->start, $period->end)->visits());

        return [
            'previous' => (int) ($results->last() ?? 0),
            'result' => (int) ($results->first() ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitsYesterday(): array
    {
        $period = CarbonPeriod::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday());

        $results = collect(Matomo::summary()->site(config('matomo-analytics.id_site'))->between($period->start, $period->end)->visits());

        return [
            'previous' => (int) ($results->last() ?? 0),
            'result' => (int) ($results->first() ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitsLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();

        $currentResults = collect(Matomo::summary()->period('range')->date("{$lastWeek['current']->start->format('Y-m-d')},{$lastWeek['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->visits());

        $previousResults = collect(Matomo::summary()->period('range')->date("{$lastWeek['previous']->start->format('Y-m-d')},{$lastWeek['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->visits());

        return [
            'previous' => (int) ($previousResults['value'] ?? 0),
            'result' => (int) ($currentResults['value'] ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitsLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();

        $currentResults = collect(Matomo::summary()->period('range')->date("{$lastMonth['current']->start->format('Y-m-d')},{$lastMonth['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->visits());

        $previousResults = collect(Matomo::summary()->period('range')->date("{$lastMonth['previous']->start->format('Y-m-d')},{$lastMonth['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->visits());

        return [
            'previous' => (int) ($previousResults['value'] ?? 0),
            'result' => (int) ($currentResults['value'] ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitsLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();

        $currentResults = collect(Matomo::summary()->period('range')->date("{$lastSevenDays['current']->start->format('Y-m-d')},{$lastSevenDays['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->visits());

        $previousResults = collect(Matomo::summary()->period('range')->date("{$lastSevenDays['previous']->start->format('Y-m-d')},{$lastSevenDays['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->visits());

        return [
            'previous' => (int) ($previousResults['value'] ?? 0),
            'result' => (int) ($currentResults['value'] ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitsLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();

        $currentResults = collect(Matomo::summary()->period('range')->date("{$lastThirtyDays['current']->start->format('Y-m-d')},{$lastThirtyDays['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->visits());

        $previousResults = collect(Matomo::summary()->period('range')->date("{$lastThirtyDays['previous']->start->format('Y-m-d')},{$lastThirtyDays['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->visits());

        return [
            'previous' => (int) ($previousResults['value'] ?? 0),
            'result' => (int) ($currentResults['value'] ?? 0),
        ];
    }
}
