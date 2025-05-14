<?php

namespace App\Filament\Widgets;

use App\Models\Menu;
use Filament\Widgets\ChartWidget;

class MenusChart extends ChartWidget
{
    protected static ?string $heading = 'Menus by Category';

    protected function getData(): array
    {
        $categories = ['ayam', 'tahu', 'minuman', 'paket keluarga', 'paket hemat'];

        $data = collect($categories)->map(function ($category) {
            return Menu::where('category', $category)->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Menus',
                    'data' => $data,
                    'backgroundColor' => [
                        '#facc15', // amber
                        '#4ade80', // green
                        '#60a5fa', // blue
                        '#f472b6', // pink
                        '#c084fc', // purple
                    ],
                ],
            ],
            'labels' => $categories,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
