<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Agencetwogether\MatomoAnalytics\Services\MatomoWidgetDataService;
use Agencetwogether\MatomoAnalytics\Support\MAFilters;
use Agencetwogether\MatomoAnalytics\Traits\CanViewWidget;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class VisitsByCountryWidget extends ChartWidget
{
    use CanViewWidget;

    protected ?string $pollingInterval = null;

    protected string $view = 'matomo-analytics::widgets.matomo-chart';

    public ?string $filter = 'today';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = collect(app(MatomoWidgetDataService::class)
            ->get('UserCountry.getCountry', $this->filter, false));

        $dataMapped = $this->transformData($data, $this->filter);

        $labels = $dataMapped->keys();
        $dataChart = $dataMapped->values();
        $colors = $this->generateColors($labels);

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => __('matomo-analytics::widgets.nb_uniq_visitors'),
                    'data' => $dataChart,
                    'backgroundColor' => $colors,
                    'fill' => 'start',
                    'cutout' => 0,
                    'hoverOffset' => 5,
                    'borderColor' => '#ffffff',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function transformData(Collection $data, string $filter): Collection
    {
        $metric = match ($filter) {
            'last_week', 'last_month' => 'sum_daily_nb_uniq_visitors',
            default => 'nb_uniq_visitors',
        };

        if ($filter === 'last_7_days' || $filter === 'last_30_days') {

            $data = collect($data->reduce(function ($carry, $items) use ($metric) {
                foreach ($items as $item) {
                    $carry[$item['label']] = ($carry[$item['label']] ?? 0) + $item[$metric];
                }

                return $carry;
            }, []));
        } else {

            $data = $data->mapWithKeys(function (array $value) use ($metric) {
                return [$value['label'] => $value[$metric]];
            });
        }

        $data = $data->sortDesc();

        $maxCountries = config('matomo-analytics.max_items_in_pie', 6);
        $top = $data->take($maxCountries);

        $othersSum = $data->slice($maxCountries)->sum();

        if ($othersSum > 0) {
            $top->put(__('matomo-analytics::widgets.others'), $othersSum);
        }

        return $top->mapWithKeys(function (int $value, string $key) {
            return ["{$key} ({$value})" => $value];
        });
    }

    protected function generateColors(Collection $labels): array
    {
        $palette = [
            '#008FFB', // blue
            '#00E396', // green
            '#FEB019', // orange
            '#FF455F', // red
            '#775DD0', // purple
            '#80EFFE', // cyan
            '#3F51B5', // indigo
            '#4CAF50', // green
            '#FFC107', // amber
            '#26A69A', // teal
            '#29B6F6', // light blue
            '#AB47BC', // violet
            '#EC407A', // pink
            '#FF7043', // deep orange
            '#9CCC65', // light green
            '#FFCA28', // yellow
            '#5C6BC0', // indigo soft
            '#26C6DA', // cyan soft
            '#EF5350', // red soft
        ];

        $colors = [];

        foreach ($labels as $index => $label) {

            if (str_contains($label, __('matomo-analytics::widgets.others'))) {
                $colors[] = '#9CA3AF';
            } else {
                $colors[] = $palette[$index % count($palette)];
            }
        }

        return $colors;
    }

    protected function getFilters(): ?array
    {
        return MAFilters::common();
    }

    public function getHeading(): string | Htmlable | null
    {
        return __('matomo-analytics::widgets.visits_by_country');
    }

    protected function getOptions(): array | RawJs | null
    {
        return RawJs::make(<<<'JS'
            {
                animation: { duration: 0 },
                elements: {
                    point: { radius: 0 },
                    hit: { radius: 0 },
                },
                maintainAspectRatio: false,
                borderRadius: 4,
                scaleBeginAtZero: true,
                radius: '85%',
                plugins: {
                    legend: {
                        display: true,
                        position: 'left',
                        align: 'bottom',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10
                            }
                        }
                    },
                },
                scales: {
                    x: { display: false },
                    y: { display: false },
                },
                tooltips: { enabled: false },
            }
        JS);
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
