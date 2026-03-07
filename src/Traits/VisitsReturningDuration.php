<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use Agencetwogether\MatomoAnalytics\Services\MatomoWidgetDataService;
use Illuminate\Support\Collection;

trait VisitsReturningDuration
{
    /** @return array{result: int, previous: int} */
    private function visitReturningDurationData(string $filter): array
    {
        $data = collect(app(MatomoWidgetDataService::class)
            ->get('VisitFrequency.get', $filter));

        if ($filter == 'last_7_days' || $filter == 'last_30_days') {
            $data = $this->mutateDataVisitsReturningDurationForLastXDays($data);
        }

        return [
            'previous' => (int) ($data->first()['avg_time_on_site_returning'] ?? 0),
            'result' => (int) ($data->last()['avg_time_on_site_returning'] ?? 0),
        ];
    }

    private function mutateDataVisitsReturningDurationForLastXDays(Collection $data): Collection
    {
        $position = 0;
        [$previous, $current] = $data->partition(function ($i) use ($data, &$position) {
            $position++;

            return $position <= $data->count() / 2;
        });

        // Calculate
        $avgTimePrevious = $previous->pluck('nb_visits_returning')->sum() > 0
            ? $previous->pluck('sum_visit_length_returning')->sum() / $previous->pluck('nb_visits_returning')->sum()
            : 0;

        $avgTimeCurrent = $current->pluck('nb_visits_returning')->sum() > 0
            ? $current->pluck('sum_visit_length_returning')->sum() / $current->pluck('nb_visits_returning')->sum()
            : 0;

        return collect([
            'previous' => [
                'avg_time_on_site_returning' => (int) round($avgTimePrevious),
            ],
            'current' => [
                'avg_time_on_site_returning' => (int) round($avgTimeCurrent),
            ],
        ]);
    }
}
