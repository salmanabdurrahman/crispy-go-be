<?php

namespace App\Filament\Widgets;

use App\Models\BlogPost;
use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Blog Posts by Type';

    protected function getData(): array
    {
        $types = ['product', 'tips', 'news', 'promotions', 'review', 'tutorial', 'interview', 'opinion', 'press-release', 'announcement'];

        $data = collect($types)->map(function ($type) {
            return BlogPost::where('type', $type)->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Blog Posts',
                    'data' => $data,
                    'backgroundColor' => [
                        '#ff6384', // red
                        '#36a2eb', // blue
                        '#cc65fe', // purple
                        '#ffce56', // yellow
                        '#2ecc71', // green
                        '#e74c3c', // red
                        '#3498db', // blue
                        '#9b59b6', // purple
                        '#f1c40f', // yellow
                        '#e67e22', // orange
                    ],
                ],
            ],
            'labels' => $types,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

