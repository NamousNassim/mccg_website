<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MccgStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Articles publiés', Article::published()->count())
                ->description(Article::where('status', 'draft')->count().' brouillon(s)')
                ->color('success'),
            Stat::make('Services actifs', Service::where('is_active', true)->count())
                ->description('Visibles sur le site')
                ->color('primary'),
            Stat::make('Nouveaux messages', ContactMessage::where('status', 'new')->count())
                ->description('À traiter')
                ->color('warning'),
        ];
    }
}
