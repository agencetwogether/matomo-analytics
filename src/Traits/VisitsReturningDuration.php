<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use BernskioldMedia\LaravelMatomo\Facades\Matomo;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait VisitsReturningDuration
{
    use MetricDiff;

    /** @return array{result: int, previous: int} */
    private function visitReturningDurationToday(): array
    {
        $period = CarbonPeriod::create(Carbon::yesterday(), Carbon::today());

        $results = collect(Matomo::frequencies()->site(config('matomo-analytics.id_site'))->between($period->start, $period->end)->all());

        return [
            'previous' => (int) ($results->last()->avg_time_on_site_returning ?? 0),
            'result' => (int) ($results->first()->avg_time_on_site_returning ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitReturningDurationYesterday(): array
    {
        $period = CarbonPeriod::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday());

        $results = collect(Matomo::frequencies()->site(config('matomo-analytics.id_site'))->between($period->start, $period->end)->all());

        return [
            'previous' => (int) ($results->last()->avg_time_on_site_returning ?? 0),
            'result' => (int) ($results->first()->avg_time_on_site_returning ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitReturningDurationLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();

        $currentResults = collect(Matomo::frequencies()->period('range')->date("{$lastWeek['current']->start->format('Y-m-d')},{$lastWeek['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        $previousResults = collect(Matomo::frequencies()->period('range')->date("{$lastWeek['previous']->start->format('Y-m-d')},{$lastWeek['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        return [
            'previous' => (int) ($previousResults['avg_time_on_site_returning'] ?? 0),
            'result' => (int) ($currentResults['avg_time_on_site_returning'] ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitReturningDurationLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();

        $currentResults = collect(Matomo::frequencies()->period('range')->date("{$lastMonth['current']->start->format('Y-m-d')},{$lastMonth['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        $previousResults = collect(Matomo::frequencies()->period('range')->date("{$lastMonth['previous']->start->format('Y-m-d')},{$lastMonth['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        return [
            'previous' => (int) ($previousResults['avg_time_on_site_returning'] ?? 0),
            'result' => (int) ($currentResults['avg_time_on_site_returning'] ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitReturningDurationLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();

        $currentResults = collect(Matomo::frequencies()->period('range')->date("{$lastSevenDays['current']->start->format('Y-m-d')},{$lastSevenDays['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        $previousResults = collect(Matomo::frequencies()->period('range')->date("{$lastSevenDays['previous']->start->format('Y-m-d')},{$lastSevenDays['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        return [
            'previous' => (int) ($previousResults['avg_time_on_site_returning'] ?? 0),
            'result' => (int) ($currentResults['avg_time_on_site_returning'] ?? 0),
        ];

    }

    /** @return array{result: int, previous: int} */
    private function visitReturningDurationLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();

        $currentResults = collect(Matomo::frequencies()->period('range')->date("{$lastThirtyDays['current']->start->format('Y-m-d')},{$lastThirtyDays['current']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        $previousResults = collect(Matomo::frequencies()->period('range')->date("{$lastThirtyDays['previous']->start->format('Y-m-d')},{$lastThirtyDays['previous']->end->format('Y-m-d')}")->site(config('matomo-analytics.id_site'))->all());

        return [
            'previous' => (int) ($previousResults['avg_time_on_site_returning'] ?? 0),
            'result' => (int) ($currentResults['avg_time_on_site_returning'] ?? 0),
        ];
    }
}
