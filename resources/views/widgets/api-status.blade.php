@php
    $pollingInterval = $this->getPollingInterval();
@endphp

<x-filament-widgets::widget
    :attributes="
        (new \Illuminate\View\ComponentAttributeBag)
            ->merge([
                'wire:poll.' . $pollingInterval => $pollingInterval ? true : null,
            ], escape: false)
    "
>
    @if ($apiDown)
        <x-filament::callout icon="heroicon-o-information-circle" color="warning">
            <x-slot name="heading">
                {{ __("matomo-analytics::widgets.api_unreachable.heading") }}
            </x-slot>
            <x-slot name="description">
                @if ($lastSuccess)
                    {{ __("matomo-analytics::widgets.api_unreachable.description", ["date" => $lastSuccess->diffForHumans()]) }}
                @endif

                @if (filled($nextCall))
                    <br />
                    {{ __("matomo-analytics::widgets.api_unreachable.next_call", ["date" => $nextCall->diffForHumans()]) }}
                @endif
            </x-slot>
        </x-filament::callout>
    @endif
</x-filament-widgets::widget>
