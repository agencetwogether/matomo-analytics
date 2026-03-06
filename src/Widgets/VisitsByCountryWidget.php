<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Agencetwogether\MatomoAnalytics\Support\MAFilters;
use Agencetwogether\MatomoAnalytics\Support\MAResponse;
use Agencetwogether\MatomoAnalytics\Traits\CanViewWidget;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class VisitsByCountryWidget extends ChartWidget
{
    use CanViewWidget;

    // @phpstan-ignore-next-line
    protected string $view = 'matomo-analytics::widgets.matomo-chart';

    public ?string $filter = 'T';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        /** @var Collection<string, int|float> $response */
        $response = collect(MAResponse::visitsByCountry($this->filter))->sortDesc();

        $labels = $response->keys()->values()->all();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => __('matomo-analytics::widgets.nb_uniq_visitors'),
                    'data' => $response->values()->all(),
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
