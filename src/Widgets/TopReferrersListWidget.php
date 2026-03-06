<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Agencetwogether\MatomoAnalytics\Support\MAFilters;
use Agencetwogether\MatomoAnalytics\Support\MAResponse;
use Agencetwogether\MatomoAnalytics\Support\SelectAction;
use Agencetwogether\MatomoAnalytics\Traits\CanViewWidget;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Pagination\LengthAwarePaginator;

class TopReferrersListWidget extends TableWidget
{
    use CanViewWidget;

    public ?string $filter = 'T';

    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('matomo-analytics::widgets.top_referrers'))
            ->records(function (int $page, int $recordsPerPage): LengthAwarePaginator {
                $records = collect(MAResponse::topReferrers($this->filter))
                    ->mapWithKeys(fn (array $item): array => [str()->uuid()->toString() => $item])
                    ->sortByDesc('nb_visits');
                $total = $records->count();
                $records = $records->forPage($page, $recordsPerPage);

                return new LengthAwarePaginator(
                    $records,
                    total: $total,
                    perPage: $recordsPerPage,
                    currentPage: $page,
                    options: ['pageName' => 'topReferrersListPage']
                );
            })
            ->queryStringIdentifier('topReferrersList')
            ->paginated([5, 10])
            ->defaultPaginationPageOption(5)
            ->columns([
                Split::make([
                    ImageColumn::make('image')
                        ->state(fn (array $record): string => config('matomo-analytics.base_url') . '/' . $record['image'])
                        ->imageWidth('18px')
                        ->imageHeight('auto')
                        ->grow(false),
                    TextColumn::make('name')
                        ->state(fn (array $record): string => filled($record['name']) ? $record['name'] : __('matomo-analytics::widgets.unknown'))
                        ->url(fn (array $record): ?string => filled($record['url']) && $record['name'] !== __('matomo-analytics::widgets.unknown') ? $record['url'] : null)
                        ->openUrlInNewTab(fn (array $record): bool => filled($record['url']) && $record['name'] !== __('matomo-analytics::widgets.unknown'))
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
                'class' => '@container [&_.fi-ta-record:not(:last-child)]:border-b [&_.fi-ta-record]:border-gray-200 dark:[&_.fi-ta-record]:border-gray-700 [&_.fi-ta-record-content-ctn]:py-2.5 [&_.fi-ta-text-item]:text-gray-700 dark:[&_.fi-ta-text-item]:text-gray-300 [&_.fi-ta-text-item]:hover:text-primary-500 dark:[&_.fi-ta-text-item]:hover:text-primary-400',
            ])
            ->headerActions([
                SelectAction::make('filter')
                    ->options(fn (): array => MAFilters::mostVisitedAndTopReferrers()),
            ])
            ->deferLoading();
    }
}
