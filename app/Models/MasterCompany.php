<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Users|null $user_created
 * @property-read \App\Models\Users|null $user_updated
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereIdCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereJumlahKaryawanKontrak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereJumlahKaryawanOutsource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereJumlahKaryawanTetap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereLuasBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereLuasTanah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereNamaCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereNamaProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereProsesUtama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereStatusBangunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCompany whereCompanyName($value)
 * @mixin \Eloquent
 */
class MasterCompany extends Model
{
    use HasFactory;
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
