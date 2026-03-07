<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use Agencetwogether\MatomoAnalytics\Services\MatomoWidgetDataService;
use Illuminate\Support\Collection;

trait VisitorsFrequencies
{
    /** @return array{result: int, previous: int} */
    private function visitorsFrequenciesData(string $filter): array
    {
        $data = collect(app(MatomoWidgetDataService::class)
            ->get('VisitFrequency.get', $filter));

        if ($filter == 'last_7_days' || $filter == 'last_30_days') {
            $data = $this->mutateDataVisitorsFrequenciesForLastXDays($data);
        }

        return [
            'previous' => (int) ($data->first()['nb_uniq_visitors_returning'] ?? 0),
            'result' => (int) ($data->last()['nb_uniq_visitors_returning'] ?? 0),
        ];
    }

    private function mutateDataVisitorsFrequenciesForLastXDays(Collection $data): Collection
    {
        $position = 0;
        [$previous, $current] = $data->partition(function ($i) use ($data, &$position) {
            $position++;

            return $position <= $data->count() / 2;
        });

        return collect([
            'previous' => [
                'nb_uniq_visitors_returning' => $previous->pluck('nb_uniq_visitors_returning')->sum(),
            ],
            'current' => [
                'nb_uniq_visitors_returning' => $current->pluck('nb_uniq_visitors_returning')->sum(),
            ],
        ]);
    }
}
