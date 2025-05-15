<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan Harian (30 Hari Terakhir)';

    protected function getData(): array
    {
        $start = now()->subDays(30)->startOfDay();
        $end = now()->endOfDay();

        // Create a list of dates 30 days ago
        $dates = collect();
        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $dates->put($date->format('Y-m-d'), 0);
        }

        // Get and count the revenue from active OrderItems
        $orderItems = OrderItem::whereBetween('created_at', [$start, $end])
            ->whereNull('deleted_at')
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->created_at)->format('Y-m-d'))
            ->map(fn($items) => $items->sum(fn($i) => $i->price));

        // Combine the revenue results with the list of dates
        $revenues = $dates->merge($orderItems);

        return [
            'datasets' => [
                [
                    'label' => 'Total Pendapatan (Rp)',
                    'data' => $revenues->values(),
                    'backgroundColor' => '#fb923c', // orange
                    'borderColor' => '#f97316',
                ],
            ],
            'labels' => $revenues->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
