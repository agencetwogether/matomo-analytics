<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use BernskioldMedia\LaravelMatomo\Facades\Matomo;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait VisitsDuration
{
    use MetricDiff;

    /** @return array{result: int, previous: int} */
    private function visitDurationToday(): array
    {
        $period = CarbonPeriod::create(Carbon::yesterday(), Carbon::today());

        $results = collect(Matomo::summary()->site(config('matomo-analytics.id_site'))->between($period->start, $period->end)->all());

        return [
            'previous' => (int) ($results->last()->avg_time_on_site ?? 0),
            'result' => (int) ($results->first()->avg_time_on_site ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitDurationYesterday(): array
    {
        $period = CarbonPeriod::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday());

        $results = collect(Matomo::summary()->site(config('matomo-analytics.id_site'))->between($period->start, $period->end)->all());

        return [
            'previous' => (int) ($results->last()->avg_time_on_site ?? 0),
            'result' => (int) ($results->first()->avg_time_on_site ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitDurationLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();

        $currentResults = collect(Matomo::summary()->period('range')->date("{$lastWeek['current']->start->format('Y-m-d')},{$lastWeek['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        $previousResults = collect(Matomo::summary()->period('range')->date("{$lastWeek['previous']->start->format('Y-m-d')},{$lastWeek['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        return [
            'previous' => (int) ($previousResults['avg_time_on_site'] ?? 0),
            'result' => (int) ($currentResults['avg_time_on_site'] ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitDurationLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();

        $currentResults = collect(Matomo::summary()->period('range')->date("{$lastMonth['current']->start->format('Y-m-d')},{$lastMonth['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        $previousResults = collect(Matomo::summary()->period('range')->date("{$lastMonth['previous']->start->format('Y-m-d')},{$lastMonth['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        return [
            'previous' => (int) ($previousResults['avg_time_on_site'] ?? 0),
            'result' => (int) ($currentResults['avg_time_on_site'] ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitDurationLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();

        $currentResults = collect(Matomo::summary()->period('range')->date("{$lastSevenDays['current']->start->format('Y-m-d')},{$lastSevenDays['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        $previousResults = collect(Matomo::summary()->period('range')->date("{$lastSevenDays['previous']->start->format('Y-m-d')},{$lastSevenDays['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        return [
            'previous' => (int) ($previousResults['avg_time_on_site'] ?? 0),
            'result' => (int) ($currentResults['avg_time_on_site'] ?? 0),
        ];

    }

    /** @return array{result: int, previous: int} */
    private function visitDurationLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();

        $currentResults = collect(Matomo::summary()->period('range')->date("{$lastThirtyDays['current']->start->format('Y-m-d')},{$lastThirtyDays['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        $previousResults = collect(Matomo::summary()->period('range')->date("{$lastThirtyDays['previous']->start->format('Y-m-d')},{$lastThirtyDays['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        return [
            'previous' => (int) ($previousResults['avg_time_on_site'] ?? 0),
            'result' => (int) ($currentResults['avg_time_on_site'] ?? 0),
        ];
    }
}
