<?php

namespace App\Filament\Widgets;

use App\Models\Projects;
use App\Models\Applications;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total des projets', Projects::count())
                ->description('Nombre total de projets')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Projets actifs', Projects::whereHas('users')->count())
                ->description('Projets avec des membres')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Candidatures', Applications::count())
                ->description('Total des candidatures')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),
        ];
    }
}
