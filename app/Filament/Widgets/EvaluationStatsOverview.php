<?php

namespace App\Filament\Widgets;

use App\Models\Evaluation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EvaluationStatsOverview extends BaseWidget
{
    // protected int|string|array $columnSpan = 12;
    protected function getStats(): array
    {
        if (auth()->user()->hasRole('Admin')) {
            return [
                Stat::make('Evaluations', Evaluation::count()),

            ];
        } else {
            return [];
        }
    }
}
