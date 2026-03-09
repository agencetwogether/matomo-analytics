<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Agencetwogether\MatomoAnalytics\Services\MatomoWidgetDataService;
use Agencetwogether\MatomoAnalytics\Support\MAFilters;
use Agencetwogether\MatomoAnalytics\Support\SelectAction;
use Agencetwogether\MatomoAnalytics\Traits\CanViewWidget;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class VisitsByCityWidget extends TableWidget
{
    use CanViewWidget;

    public ?string $filter = 'today';

    protected static ?int $sort = 2;

    protected function getData(): Collection
    {
        $data = collect(app(MatomoWidgetDataService::class)
            ->get('UserCountry.getCity', $this->filter, false));

        return $this->transformData($data, $this->filter);
    }

    protected function transformData(Collection $data, string $filter): Collection
    {
        return $data->map(fn ($pageRow): array => [
            'city' => $pageRow['city_name'],
            'region' => $pageRow['region_name'],
            'country' => $pageRow['country_name'],
            'image' => $pageRow['logo'],
            'nb_visits' => (int) $pageRow['nb_visits'],
        ])
            ->mapWithKeys(fn (array $item): array => [str()->uuid()->toString() => $item])
            ->sortByDesc('nb_visits');
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('matomo-analytics::widgets.visits_by_city'))
            ->records(function (int $page, int $recordsPerPage): LengthAwarePaginator {
                $records = $this->getData();
                $total = $records->count();
                $records = $records->forPage($page, $recordsPerPage);

                return new LengthAwarePaginator(
                    $records,
                    total: $total,
                    perPage: $recordsPerPage,
                    currentPage: $page,
                    options: ['pageName' => 'visitsByCityPage']
                );
            })
            ->queryStringIdentifier('visitsByCity')
            ->paginated([5, 10])
            ->defaultPaginationPageOption(5)
            ->columns([
                Split::make([
                    ImageColumn::make('image')
                        ->state(fn (array $record): string => config('matomo-analytics.base_url') . '/' . $record['image'])
                        ->imageWidth('18px')
                        ->imageHeight('auto')
                        ->grow(false),
                    TextColumn::make('city')
                        ->tooltip(fn (array $record): string => $record['region'])
                        ->alignStart()
                        ->weight(FontWeight::Medium)
                        ->wrap(),
                    TextColumn::make('nb_visits')
                        ->badge()
                        ->color('primary')
                        ->alignEnd()
                        ->grow(false),
                ]),
            ])
            ->extraAttributes([
                'class' => '@container [&_.fi-ta-record:not(:last-child)]:border-b [&_.fi-ta-record]:border-gray-200 dark:[&_.fi-ta-record]:border-gray-700 [&_.fi-ta-record-content-ctn]:py-2.5 [&_.fi-ta-text-item]:cursor-default',
            ])
            ->headerActions([
                SelectAction::make('filter')
                    ->options(fn (): array => MAFilters::mostVisitedAndTopReferrers()),
            ])
            ->emptyStateHeading(__('matomo-analytics::widgets.no_data'))
            ->emptyStateIcon(Heroicon::CircleStack)
            ->deferLoading();
    }
}
