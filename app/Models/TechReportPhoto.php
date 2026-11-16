<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechReportPhoto extends Model
{
    protected $fillable = [
        'client_uuid',
        'tech_report_id',
        'path',
        'caption',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(TechReport::class, 'tech_report_id');
    }
}
