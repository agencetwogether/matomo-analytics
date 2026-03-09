<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use Agencetwogether\MatomoAnalytics\Services\MatomoWidgetDataService;
use Illuminate\Support\Collection;

trait Visitors
{
    /** @return array{result: int, previous: int} */
    private function visitorsData(string $filter): array
    {
        $data = collect(app(MatomoWidgetDataService::class)
            ->get('VisitsSummary.get', $filter));

        if ($filter == 'last_7_days' || $filter == 'last_30_days') {
            $data = $this->mutateDataVisitorsForLastXDays($data);
        }

        return [
            'previous' => (int) ($data->first()['nb_uniq_visitors'] ?? 0),
            'result' => (int) ($data->last()['nb_uniq_visitors'] ?? 0),
        ];
    }

    private function mutateDataVisitorsForLastXDays(Collection $data): Collection
    {
        $position = 0;
        [$previous, $current] = $data->partition(function ($i) use ($data, &$position) {
            $position++;

            return $position <= $data->count() / 2;
        });

        return collect([
            'previous' => [
                'nb_uniq_visitors' => $previous->pluck('nb_uniq_visitors')->sum(),
            ],
            'current' => [
                'nb_uniq_visitors' => $current->pluck('nb_uniq_visitors')->sum(),
            ],
        ]);
    }
}
