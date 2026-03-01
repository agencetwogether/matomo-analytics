<?php

namespace Agencetwogether\MatomoAnalytics\Support;

use Filament\Widgets\StatsOverviewWidget\Stat;

class MAStats extends Stat
{
    protected string $view = 'matomo-analytics::widgets.matomo-stats';

    public ?string $filter = null;

    /**
     * @var array<int|string, string>|null
     */
    protected ?array $options = null;

    /**
     * @param  array<int|string, string> | null  $options
     */
    public function select(?array $options, ?string $filter = null): static
    {
        $this->options = $options;
        $this->filter = $filter;

        return $this;
    }

    public function getFilter(): ?string
    {
        return $this->filter;
    }

    /**
     * @return array<int|string, string>|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }
}
