<?php

namespace Agencetwogether\MatomoAnalytics\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class MatomoApiStatusWidget extends Widget
{
    protected string $view = 'matomo-analytics::widgets.api-status';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = -100;

    protected ?string $pollingInterval = '10s';

    protected function getPollingInterval(): ?string
    {
        return $this->pollingInterval;
    }

    protected function getViewData(): array
    {
        return [
            'apiDown' => Cache::has('matomo_api_down') && Cache::get('matomo_api_down')['isDown'],
            'lastSuccess' => Cache::get('matomo_last_success'),
            'nextCall' => Cache::has('matomo_api_down') ? Cache::get('matomo_api_down')['nextCall'] : null,
        ];
    }
}
