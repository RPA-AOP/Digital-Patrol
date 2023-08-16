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
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * App\Models\ReportAccidentAttachment
 *
 * @property int $report_accident_attachment_id
 * @property string $path
 * @property string $extension
 * @property int|null $report_accident_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\ReportAccident|null $reportAccident
 * @method static Builder|ReportAccidentAttachment newModelQuery()
 * @method static Builder|ReportAccidentAttachment newQuery()
 * @method static Builder|ReportAccidentAttachment query()
 * @method static Builder|ReportAccidentAttachment whereCreatedAt($value)
 * @method static Builder|ReportAccidentAttachment whereExtension($value)
 * @method static Builder|ReportAccidentAttachment wherePath($value)
 * @method static Builder|ReportAccidentAttachment whereReportAccidentAttachmentId($value)
 * @method static Builder|ReportAccidentAttachment whereReportAccidentId($value)
 * @method static Builder|ReportAccidentAttachment whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ReportAccidentAttachment extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }


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
