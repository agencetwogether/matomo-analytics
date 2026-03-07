<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use Agencetwogether\MatomoAnalytics\Services\MatomoWidgetDataService;
use Illuminate\Support\Collection;

trait Visits
{
    /** @return array{result: int, previous: int} */
    private function visitsData(string $filter): array
    {
        $data = collect(app(MatomoWidgetDataService::class)
            ->get('VisitsSummary.get', $filter));

        if ($filter == 'last_7_days' || $filter == 'last_30_days') {
            $data = $this->mutateDataVisitsForLastXDays($data);
        }

        return [
            'previous' => (int) ($data->first()['nb_visits'] ?? 0),
            'result' => (int) ($data->last()['nb_visits'] ?? 0),
        ];
    }

    private function mutateDataVisitsForLastXDays(Collection $data): Collection
    {
        $position = 0;
        [$previous, $current] = $data->partition(function ($i) use ($data, &$position) {
            $position++;

            return $position <= $data->count() / 2;
        });

        return collect([
            'previous' => [
                'nb_visits' => $previous->pluck('nb_visits')->sum(),
            ],
            'current' => [
                'nb_visits' => $current->pluck('nb_visits')->sum(),
            ],
        ]);
    }
}
