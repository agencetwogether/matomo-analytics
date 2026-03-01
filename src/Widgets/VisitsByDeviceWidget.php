<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Agencetwogether\MatomoAnalytics\Support\MAFilters;
use Agencetwogether\MatomoAnalytics\Support\MAResponse;
use Agencetwogether\MatomoAnalytics\Traits\CanViewWidget;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

class VisitsByDeviceWidget extends ChartWidget
{
    use CanViewWidget;

    public ?string $filter = 'T';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = collect(MAResponse::visitsByDevice($this->filter))
            ->filter(fn (mixed $item, string $key): bool => Str::doesntContain($key, 'total', ignoreCase: true))
            ->values()
            ->toArray();

        return [
            'labels' => array_keys(MAResponse::visitsByDevice($this->filter)),
            'datasets' => [
                [
                    'label' => __('matomo-analytics::widgets.nb_uniq_visitors'),
                    'data' => $data,
                    'backgroundColor' => [
                        '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
                    ],
                    'fill' => 'start',
                    'cutout' => '55%',
                    'hoverOffset' => 5,
                    'borderColor' => 'transparent',
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
        return __('matomo-analytics::widgets.visits_by_device');
    }

    protected function getOptions(): array | RawJs | null
    {
        return RawJs::make(<<<'JS'
            {
                animation: {
                    duration: 0,
                },
                elements: {
                    point: {
                        radius: 0,
                    },
                    hit: {
                        radius: 0,
                    },

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
                    x: {
                        display: false,
                    },
                    y: {
                        display: false,
                    },
                },
                tooltips: {
                    enabled: false,
                },
            }
        JS);
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
