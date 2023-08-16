<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\MasterCompany
 *
 * @property int $id_company
 * @property string|null $company_name
 * @property string|null $alamat
 * @property int|null $luas_tanah
 * @property int|null $luas_bangunan
 * @property string $status_bangunan
 * @property int|null $jumlah_karyawan_tetap
 * @property int|null $jumlah_karyawan_kontrak
 * @property int|null $jumlah_karyawan_outsource
 * @property string|null $nama_produk
 * @property string|null $proses_utama
 * @property string|null $lat
 * @property string|null $long
 * @property bool $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Users|null $user_created
 * @property-read Users|null $user_updated
 * @method static Builder|MasterCompany newModelQuery()
 * @method static Builder|MasterCompany newQuery()
 * @method static Builder|MasterCompany query()
 * @method static Builder|MasterCompany whereAlamat($value)
 * @method static Builder|MasterCompany whereCompanyName($value)
 * @method static Builder|MasterCompany whereCreatedAt($value)
 * @method static Builder|MasterCompany whereCreatedBy($value)
 * @method static Builder|MasterCompany whereIdCompany($value)
 * @method static Builder|MasterCompany whereJumlahKaryawanKontrak($value)
 * @method static Builder|MasterCompany whereJumlahKaryawanOutsource($value)
 * @method static Builder|MasterCompany whereJumlahKaryawanTetap($value)
 * @method static Builder|MasterCompany whereLat($value)
 * @method static Builder|MasterCompany whereLong($value)
 * @method static Builder|MasterCompany whereLuasBangunan($value)
 * @method static Builder|MasterCompany whereLuasTanah($value)
 * @method static Builder|MasterCompany whereNamaProduk($value)
 * @method static Builder|MasterCompany whereProsesUtama($value)
 * @method static Builder|MasterCompany whereStatus($value)
 * @method static Builder|MasterCompany whereStatusBangunan($value)
 * @method static Builder|MasterCompany whereUpdatedAt($value)
 * @method static Builder|MasterCompany whereUpdatedBy($value)
 * @mixin Eloquent
 */
class MasterCompany extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    protected $table = 'master_company';
    protected $primaryKey = 'id_company';
    protected $fillable = [
        'company_name',
        'alamat',
        'luas_tanah',
        'luas_bangunan',
        'status_bangunan',
        'jumlah_karyawan_tetap',
        'jumlah_karyawan_kontrak',
        'jumlah_karyawan_outsource',
        'nama_produk',
        'proses_utama',
        'lat',
        'long',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    public function user_created()
    {
        return $this->belongsTo(Users::class, 'created_by', 'id_user');
    }

    public function user_updated()
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id_user');
    }
}
