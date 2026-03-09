<?php

namespace Agencetwogether\MatomoAnalytics\Traits;

use Agencetwogether\MatomoAnalytics\Services\MatomoWidgetDataService;
use Illuminate\Support\Collection;

trait PageViews
{
    /** @return array{result: int, previous: int} */
    private function pageViewsData(string $filter): array
    {
        $data = collect(app(MatomoWidgetDataService::class)
            ->get('VisitsSummary.get', $filter));

        if ($filter == 'last_7_days' || $filter == 'last_30_days') {
            $data = $this->mutateDataPageViewsForLastXDays($data);
        }

        return [
            'previous' => (int) ($data->first()['nb_actions'] ?? 0),
            'result' => (int) ($data->last()['nb_actions'] ?? 0),
        ];
    }

    private function mutateDataPageViewsForLastXDays(Collection $data): Collection
    {
        $position = 0;
        [$previous, $current] = $data->partition(function ($i) use ($data, &$position) {
            $position++;

            return $position <= $data->count() / 2;
        });

        return collect([
            'previous' => [
                'nb_actions' => $previous->pluck('nb_actions')->sum(),
            ],
            'current' => [
                'nb_actions' => $current->pluck('nb_actions')->sum(),
            ],
        ]);
    }
}
