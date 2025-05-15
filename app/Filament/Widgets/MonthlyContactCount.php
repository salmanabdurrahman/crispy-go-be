<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class MonthlyContactCount extends ChartWidget
{
    protected static ?string $heading = 'Pesan Kontak (30 Hari Terakhir)';

    protected function getData(): array
    {
        $start = now()->subDays(30)->startOfDay();
        $end = now()->endOfDay();

        $dates = collect();
        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $dates->put($date->format('Y-m-d'), 0);
        }

        $contactCounts = ContactMessage::whereBetween('created_at', [$start, $end])
            ->whereNull('deleted_at')
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->created_at)->format('Y-m-d'))
            ->map(fn($items) => $items->count());

        $merged = $dates->merge($contactCounts);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pesan Kontak',
                    'data' => $merged->values(),
                    'backgroundColor' => '#60a5fa', // biru muda
                    'borderColor' => '#3b82f6',
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
