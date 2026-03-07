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

    // @phpstan-ignore-next-line
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

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => __('matomo-analytics::widgets.nb_uniq_visitors'),
                    'data' => $dataChart,
                    'backgroundColor' => [
                        '#008FFB',
                        '#00E396',
                        '#FEB019',
                        '#FF455F',
                        '#775DD0',
                        '#80EFFE',
                    ],
                    'fill' => 'start',
                    'cutout' => '55%',
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

        if ($filter == 'last_7_days' || $filter == 'last_30_days') {

            return collect($data->reduce(function ($carry, $items) use ($metric) {
                foreach ($items as $item) {
                    $carry[$item['label']] = ($carry[$item['label']] ?? 0) + $item[$metric];
                }

                return $carry;
            }, []))
                ->mapWithKeys(function (int $value, string $key) {
                    return ["{$key} ({$value})" => $value];
                })
                ->sortDesc();
        }

        return $data->mapWithKeys(function (array $value, int $key) use ($metric) {
            return [$value['label'] . ' (' . $value[$metric] . ')' => $value[$metric]];
        })->sortDesc();
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
        return 'doughnut';
    }
}
