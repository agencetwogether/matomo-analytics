<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Agencetwogether\MatomoAnalytics\Support\MAFilters;
use Agencetwogether\MatomoAnalytics\Support\MAResponse;
use Agencetwogether\MatomoAnalytics\Traits\CanViewWidget;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class VisitsPerHourWidget extends ChartWidget
{
    use CanViewWidget;

    protected ?string $pollingInterval = null;
    
    // @phpstan-ignore-next-line
    protected string $view = 'matomo-analytics::widgets.matomo-chart';

    public ?string $filter = 'T';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        /** @var Collection<string, int|float> $response */
        $response = collect(MAResponse::visitsPerHour($this->filter));

        $labels = $response->keys()->values()->all();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => __('matomo-analytics::widgets.nb_uniq_visitors'),
                    'data' => $response->values()->all(),
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
                    legend: { display: false }
                }
            }
        JS);
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
