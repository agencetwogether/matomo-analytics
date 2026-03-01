<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Agencetwogether\MatomoAnalytics\Support\MAFilters;
use Agencetwogether\MatomoAnalytics\Support\MAResponse;
use Agencetwogether\MatomoAnalytics\Traits\CanViewWidget;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class VisitsPerHourWidget extends ChartWidget
{
    use CanViewWidget;

    public ?string $filter = 'T';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = collect(MAResponse::visitsPerHour($this->filter))
            ->values()
            ->toArray();

        $labels = array_keys(MAResponse::visitsPerHour($this->filter));

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => __('matomo-analytics::widgets.nb_uniq_visitors'),
                    'data' => $data,
                    'borderWidth' => 1,
                    'barPercentage' => 1,
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
        return __('matomo-analytics::widgets.visits_per_hour');
    }

    protected function getOptions(): array | RawJs | null
    {
        return RawJs::make(<<<'JS'
            {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        JS);
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
