<?php

declare(strict_types=1);

namespace Agencetwogether\MatomoAnalytics;

use Filament\Widgets\WidgetConfiguration;
use Livewire\Livewire;
use Livewire\Mechanisms\ComponentRegistry;

class WidgetManager
{
    /**
     * @var array<string, string>
     */
    protected array $livewireComponents = [];

    /**
     * @var array<int, class-string>
     */
    protected array $widgets = [
        Widgets\MostVisitedPagesWidget::class,
        Widgets\PageViewsWidget::class,
        Widgets\TopReferrersListWidget::class,
        Widgets\VisitorsFrequenciesDurationWidget::class,
        Widgets\VisitorsFrequenciesWidget::class,
        Widgets\VisitorsWidget::class,
        Widgets\VisitsByBrowserListWidget::class,
        Widgets\VisitsByCityWidget::class,
        Widgets\VisitsByCountryWidget::class,
        Widgets\VisitsByDeviceWidget::class,
        Widgets\VisitsByModelListWidget::class,
        Widgets\VisitsDurationWidget::class,
        Widgets\VisitsPerHourWidget::class,
        Widgets\VisitsWidget::class,
    ];

    public static function make(): static
    {
        return app(static::class);
    }

    public function boot(): void
    {
        $this->enqueueWidgetsForRegistration();

        foreach ($this->livewireComponents as $componentName => $componentClass) {
            Livewire::component($componentName, $componentClass);
        }

        $this->livewireComponents = [];
    }

    protected function enqueueWidgetsForRegistration(): void
    {
        foreach ($this->widgets as $widget) {
            $this->queueLivewireComponentForRegistration($this->normalizeWidgetClass($widget));
        }
    }

    /**
     * @param  class-string | WidgetConfiguration  $widget
     * @return class-string
     */
    public function normalizeWidgetClass(string | WidgetConfiguration $widget): string
    {
        if ($widget instanceof WidgetConfiguration) {
            return $widget->widget;
        }

        return $widget;
    }

    protected function queueLivewireComponentForRegistration(string $component): void
    {
        $componentName = $this->getComponentAlias($component);

        $this->livewireComponents[$componentName] = $component;
    }

    private function getComponentAlias(string $component): string
    {
        // @phpstan-ignore class.notFound
        if (app()->has(ComponentRegistry::class)) {

            // @phpstan-ignore-next-line
            return app(ComponentRegistry::class)->getClass($component);
        }

        return app('livewire.finder')->resolveClassComponentClassName($component);
    }
}
