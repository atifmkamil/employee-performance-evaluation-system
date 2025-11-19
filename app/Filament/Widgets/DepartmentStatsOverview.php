<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DepartmentStatsOverview extends BaseWidget
{

    protected function getStats(): array
    {

        if (auth()->user()->hasRole('Admin')) {
            return [
                Stat::make('Deparments', Department::count()),
                Stat::make('Positions', Position::count()),
                Stat::make('Employees', User::role('pegawai')->count()),
                // Stat::make('Unique views', '192.1k')
                //     ->description('32k increase')
                //     ->descriptionIcon('heroicon-m-arrow-trending-up')
                //     ->chart([7, 2, 10, 3, 15, 4, 17])
            ];
        } else {
            return [
                // Stat::make('Deparments', Department::count()),
                // Stat::make('Positions', Position::count()),
                // Stat::make('Employees', User::role('pegawai')->count()),
                // Stat::make('Unique views', '192.1k')
                //     ->description('32k increase')
                //     ->descriptionIcon('heroicon-m-arrow-trending-up')
                //     ->chart([7, 2, 10, 3, 15, 4, 17])
            ];
        }
    }
}
