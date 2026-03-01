<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use BernskioldMedia\LaravelMatomo\Facades\Matomo;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait VisitorsFrequencies
{
    use MetricDiff;

    /** @return array{result: int, previous: int} */
    private function visitorsFrequenciesToday(): array
    {
        $period = CarbonPeriod::create(Carbon::yesterday(), Carbon::today());

        $results = collect(Matomo::frequencies()->site(config('matomo-analytics.id_site'))->between($period->start, $period->end)->all());

        return [
            'result' => (int) ($results->last()->nb_uniq_visitors_returning ?? 0),
            'previous' => (int) ($results->first()->nb_uniq_visitors_returning ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitorsFrequenciesYesterday(): array
    {
        $period = CarbonPeriod::create(Carbon::yesterday()->clone()->subDay(), Carbon::yesterday());

        $results = collect(Matomo::frequencies()->site(config('matomo-analytics.id_site'))->between($period->start, $period->end)->all());

        return [
            'result' => (int) ($results->last()->nb_uniq_visitors_returning ?? 0),
            'previous' => (int) ($results->first()->nb_uniq_visitors_returning ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitorsFrequenciesLastWeek(): array
    {
        $lastWeek = $this->getLastWeek();

        $results = collect(Matomo::frequencies()->site(config('matomo-analytics.id_site'))->period('week')->date("{$lastWeek['previous']->end->format('Y-m-d')},{$lastWeek['current']->end->format('Y-m-d')}")->all());

        return [
            'previous' => (int) ($results->first()->nb_uniq_visitors_returning ?? 0),
            'result' => (int) ($results->last()->nb_uniq_visitors_returning ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitorsFrequenciesLastMonth(): array
    {
        $lastMonth = $this->getLastMonth();

        $results = collect(Matomo::frequencies()->site(config('matomo-analytics.id_site'))->period('month')->date("{$lastMonth['previous']->end->format('Y-m-d')},{$lastMonth['current']->end->format('Y-m-d')}")->all());

        return [
            'previous' => (int) ($results->first()->nb_uniq_visitors_returning ?? 0),
            'result' => (int) ($results->last()->nb_uniq_visitors_returning ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitorsFrequenciesLastSevenDays(): array
    {
        $lastSevenDays = $this->getLastSevenDays();

        $results = collect(Matomo::frequencies()->site(config('matomo-analytics.id_site'))->period('day')->date("{$lastSevenDays['previous']->start->format('Y-m-d')},{$lastSevenDays['current']->end->format('Y-m-d')}")->all());

        $position = 0;
        [$previous, $current] = $results->partition(function ($i) use ($results, &$position) {
            $position++;

            return $position <= $results->count() / 2;
        });

        return [
            'previous' => (int) ($previous->sum('nb_uniq_visitors_returning') ?? 0),
            'result' => (int) ($current->sum('nb_uniq_visitors_returning') ?? 0),
        ];
    }

    /** @return array{result: int, previous: int} */
    private function visitorsFrequenciesLastThirtyDays(): array
    {
        $lastThirtyDays = $this->getLastThirtyDays();

        $results = collect(Matomo::frequencies()->site(config('matomo-analytics.id_site'))->period('day')->date("{$lastThirtyDays['previous']->start->format('Y-m-d')},{$lastThirtyDays['current']->end->format('Y-m-d')}")->all());

        $position = 0;
        [$previous, $current] = $results->partition(function ($i) use ($results, &$position) {
            $position++;

            return $position <= $results->count() / 2;
        });

        return [
            'previous' => (int) ($previous->sum('nb_uniq_visitors_returning') ?? 0),
            'result' => (int) ($current->sum('nb_uniq_visitors_returning') ?? 0),
        ];
    }
}
