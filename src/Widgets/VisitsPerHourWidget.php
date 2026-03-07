<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Agencetwogether\MatomoAnalytics\Services\MatomoWidgetDataService;
use Agencetwogether\MatomoAnalytics\Support\MAFilters;
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

    public ?string $filter = 'today';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = collect(app(MatomoWidgetDataService::class)
            ->get('VisitTime.getVisitInformationPerLocalTime', $this->filter, false));

        $dataMapped = $this->transformData($data, $this->filter);

        $labels = $dataMapped->keys();
        $dataChart = $dataMapped->values();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => __('matomo-analytics::widgets.nb_uniq_visitors'),
                    'data' => $dataChart,
                    'borderWidth' => 1,
                    'barPercentage' => 1,
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
                    return ["{$this->cleanLabel($key)}" => $value];
                });
        }

        return $data->mapWithKeys(function (array $value, int $key) use ($metric) {
            return [$this->cleanLabel($value['label']) => $value[$metric]];
        });
    }

    protected function cleanLabel(string $label)
    {
        return rtrim($label, ' h') . ' h';
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
