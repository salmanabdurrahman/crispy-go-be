<?php

namespace App\Filament\Widgets;

use App\Models\NewsletterSubscription;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class NewsletterSubscriptionChart extends ChartWidget
{
    protected static ?string $heading = 'Pelanggan Newsletter (30 Hari Terakhir)';

    protected function getData(): array
    {
        $start = now()->subDays(30)->startOfDay();
        $end = now()->endOfDay();

        $dates = collect();
        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $dates->put($date->format('Y-m-d'), 0);
        }

        $subCounts = NewsletterSubscription::whereBetween('created_at', [$start, $end])
            ->whereNull('deleted_at')
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->created_at)->format('Y-m-d'))
            ->map(fn($items) => $items->count());

        $merged = $dates->merge($subCounts);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Subscriber',
                    'data' => $merged->values(),
                    'backgroundColor' => '#34d399', // hijau
                    'borderColor' => '#10b981',
                ],
            ],
            'labels' => $merged->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
