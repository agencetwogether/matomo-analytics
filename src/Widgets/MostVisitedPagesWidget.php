<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Agencetwogether\MatomoAnalytics\Services\MatomoWidgetDataService;
use Agencetwogether\MatomoAnalytics\Support\MAFilters;
use Agencetwogether\MatomoAnalytics\Support\SelectAction;
use Agencetwogether\MatomoAnalytics\Traits\CanViewWidget;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MostVisitedPagesWidget extends TableWidget
{
    use CanViewWidget;

    public ?string $filter = 'today';

    protected static ?int $sort = 5;

    protected function getData(): Collection
    {
        $data = collect(app(MatomoWidgetDataService::class)
            ->get('Actions.getPageTitles', $this->filter, false));

        return $this->transformData($data, $this->filter);
    }

    protected function transformData(Collection $data, string $filter): Collection
    {
        return $data->map(fn ($pageRow): array => [
            'name' => $pageRow['label'],
            'nb_visits' => (int) $pageRow['nb_visits'],
        ])
            ->mapWithKeys(fn (array $item): array => [str()->uuid()->toString() => $item])
            ->sortByDesc('nb_visits');

    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('matomo-analytics::widgets.most_visited_pages'))
            ->records(function (int $page, int $recordsPerPage): LengthAwarePaginator {
                $records = $this->getData();
                $total = $records->count();
                $records = $records->forPage($page, $recordsPerPage);

                return new LengthAwarePaginator(
                    $records,
                    total: $total,
                    perPage: $recordsPerPage,
                    currentPage: $page,
                    options: ['pageName' => 'mostVisitedPagesPage']
                );
            })
            ->queryStringIdentifier('mostVisitedPages')
            ->paginated([5, 10])
            ->defaultPaginationPageOption(5)
            ->columns([
                Split::make([
                    TextColumn::make('name')
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
