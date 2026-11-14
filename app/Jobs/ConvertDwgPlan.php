<?php

namespace App\Jobs;

use App\Models\Plan;
use App\Services\DwgConverter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Convertit un plan DWG en PDF (exécuté tout de suite avec QUEUE_CONNECTION=sync,
 * sinon par un worker : php artisan queue:work).
 */
class ConvertDwgPlan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;
    public int $tries = 1;

    public function __construct(public int $planId)
    {
    }

    public function handle(DwgConverter $converter): void
    {
        $plan = Plan::find($this->planId);
        if (! $plan || $plan->kind !== 'dwg') {
            return;
        }

        $plan->update(['conversion_status' => 'processing', 'conversion_error' => null]);

        $disk = Storage::disk('public');
        $source = Str::after($plan->file, 'storage/');
        $target = preg_replace('/\.dwg$/i', '', $source) . '.pdf';

        try {
            $converter->toPdf($disk->path($source), $disk->path($target));
            $plan->update([
                'converted_file' => "storage/$target",
                'conversion_status' => 'done',
                'conversion_error' => null,
            ]);
        } catch (\Throwable $e) {
            Log::warning("Conversion DWG du plan {$plan->id} : " . $e->getMessage());
            $plan->update(['conversion_status' => 'failed', 'conversion_error' => Str::limit($e->getMessage(), 1000)]);
        }
    }
}
