<?php

namespace Agencetwogether\MatomoAnalytics\Support;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Traits\Macroable;

final class Period
{
    use Macroable;

    public DateTimeInterface $startDate;

    public DateTimeInterface $endDate;

    public function __construct(DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        $this->startDate = $startDate;

        $this->endDate = $endDate;
    }

    public static function days(int $numberOfDays): static
    {
        $endDate = Carbon::today();

        $startDate = Carbon::today()->subDays($numberOfDays)->startOfDay();

        return new self($startDate, $endDate);
    }

    public static function months(int $numberOfMonths): static
    {
        $endDate = Carbon::today();

        $startDate = Carbon::today()->subMonths($numberOfMonths)->startOfDay();

        return new static($startDate, $endDate);
    }

    public static function years(int $numberOfYears): static
    {
        $endDate = Carbon::today();

        $startDate = Carbon::today()->subYears($numberOfYears)->startOfDay();

        return new static($startDate, $endDate);
    }
}
