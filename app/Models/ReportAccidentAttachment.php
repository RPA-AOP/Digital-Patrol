<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;


class ReportAccidentAttachment extends Model
{
    use HasFactory;

    protected $casts = ['status' => 'boolean'];
    protected $table = 'report_accident_attachment';
    protected $primaryKey = 'report_accident_attachment_id';
    protected $fillable = [
        'report_accident_id',
        'path',
        'extension',
    ];

    public function reportAccident(): BelongsTo
    {
        return $this->belongsTo(ReportAccident::class, 'report_accident_id', 'report_accident_id');
    }
}
