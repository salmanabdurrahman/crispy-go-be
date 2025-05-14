<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderItem;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Orders & Items Sold';

    protected function getData(): array
    {
        $orders = Trend::model(Order::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->count();

        $items = Trend::model(OrderItem::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->sum('quantity');

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $orders->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#34d399', // green
                ],
                [
                    'label' => 'Items Sold',
                    'data' => $items->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#f87171', // red
                ],
            ],
            'labels' => $orders->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
