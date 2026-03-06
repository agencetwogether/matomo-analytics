<?php

declare(strict_types=1);

namespace Agencetwogether\MatomoAnalytics\Support;

use Filament\Actions\SelectAction as BaseSelectAction;
use Filament\Support\Enums\IconSize;
use Illuminate\View\ComponentAttributeBag;

use function Filament\Support\generate_loading_indicator_html;

class SelectAction extends BaseSelectAction
{
    public function toEmbeddedHtml(): string
    {
        $id = $this->getId();
        $isDisabled = $this->isDisabled();
        $name = $this->getName();

        $componentAttributeBag = (new ComponentAttributeBag)
            ->class([
                'fi-input-wrp relative',
                'fi-disabled' => $isDisabled,
                '@[320px]:w-auto w-9 relative mx-auto group ring-0 @[320px]:ring-1',
            ]);

        $inputAttributes = (new ComponentAttributeBag)
            ->merge([
                'disabled' => $isDisabled,
                'id' => $id,
                'wire:model.live' => $name,
                // 'wire:loading.attr' => 'disabled',
                'wire:loading.class' => 'pl-8',
                'wire:target' => $name,
            ], escape: false)
            ->class([
                'fi-select-input',
                'pr-8',
                'w-full cursor-pointer [background-size:0!important] @[320px]:[background-size:24px!important]',
            ]);

        $iconAttributes = (new ComponentAttributeBag)
            ->merge([
                'wire:loading.class' => 'transition-opacity duration-300 opacity-0',
            ], escape: false)
            ->class([
                'text-gray-400 size-4 dark:text-gray-500 group-hover:text-primary-500 dark:group-hover:text-primary-400',
            ]);

        // Loading indicator attributes
        $spinnerAttributes = (new ComponentAttributeBag)
            ->merge([
                'wire:loading.flex' => true,
                'wire:loading.class.remove' => 'hidden',
                'wire:target' => $name,
            ], escape: false)
            ->class([
                'absolute hidden items-center justify-center w-4 h-4 -translate-y-1/2 pointer-events-none left-2 top-1/2',
            ]);

        ob_start(); ?>

        <div class="fi-ac-select-action">
            <label for="<?= $id ?>" class="fi-sr-only">
                <?= e($this->getLabel()) ?>
            </label>
            <div <?= $componentAttributeBag->toHtml() ?>>
                <div class="@[320px]:hidden absolute inset-0 flex items-center justify-center w-9 pointer-events-none z-10 group">
                    <?= e(\Filament\Support\generate_icon_html(icon: 'heroicon-o-funnel', alias: 'ga::stats.filter', attributes: $iconAttributes)) ?>
                </div>
                <select <?= $inputAttributes->toHtml() ?>>
                    <?php if (($placeholder = $this->getPlaceholder()) !== null) { ?>
                        <option value=""><?= e($placeholder) ?></option>
                    <?php } ?>
                    <?php foreach ($this->getOptions() as $value => $label) { ?>
                        <option value="<?= e($value) ?>"><?= e($label) ?></option>
                    <?php } ?>
                </select>
                <!-- ✨ loading indicator -->
                <div <?= $spinnerAttributes->toHtml() ?> aria-hidden="true">
                    <?= generate_loading_indicator_html(
                        new ComponentAttributeBag([
                            'class' => 'text-gray-400 dark:text-gray-300',
                        ]),
                        IconSize::Medium
                    )->toHtml(); ?>
                </div>
            </div>
        </div>
        <?php return ob_get_clean() ?: '';
    }
}
