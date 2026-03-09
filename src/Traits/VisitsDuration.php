<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use Agencetwogether\MatomoAnalytics\Services\MatomoWidgetDataService;
use Illuminate\Support\Collection;

trait VisitsDuration
{
    /** @return array{result: int, previous: int} */
    private function visitDurationData(string $filter): array
    {
        $data = collect(app(MatomoWidgetDataService::class)
            ->get('VisitsSummary.get', $filter));

        if ($filter == 'last_7_days' || $filter == 'last_30_days') {
            $data = $this->mutateDataVisitsDurationForLastXDays($data);
        }

        return [
            'previous' => (int) ($data->first()['avg_time_on_site'] ?? 0),
            'result' => (int) ($data->last()['avg_time_on_site'] ?? 0),
        ];
    }

    private function mutateDataVisitsDurationForLastXDays(Collection $data): Collection
    {
        $position = 0;
        [$previous, $current] = $data->partition(function ($i) use ($data, &$position) {
            $position++;

            return $position <= $data->count() / 2;
        });

        // Calculate
        $avgTimePrevious = $previous->pluck('nb_visits')->sum() > 0
            ? $previous->pluck('sum_visit_length')->sum() / $previous->pluck('nb_visits')->sum()
            : 0;

        $avgTimeCurrent = $current->pluck('nb_visits')->sum() > 0
            ? $current->pluck('sum_visit_length')->sum() / $current->pluck('nb_visits')->sum()
            : 0;

        return collect([
            'previous' => [
                'avg_time_on_site' => (int) round($avgTimePrevious),
            ],
            'current' => [
                'avg_time_on_site' => (int) round($avgTimeCurrent),
            ],
        ]);
    }
}
