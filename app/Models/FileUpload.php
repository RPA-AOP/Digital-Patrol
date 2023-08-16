<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\FileUpload
 *
 * @property int $id_file_upload
 * @property int $tahun
 * @property string $jenis_dokumen
 * @property string $nama_lampiran
 * @property string $path_file
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|FileUpload newModelQuery()
 * @method static Builder|FileUpload newQuery()
 * @method static Builder|FileUpload query()
 * @method static Builder|FileUpload whereCreatedAt($value)
 * @method static Builder|FileUpload whereIdFileUpload($value)
 * @method static Builder|FileUpload whereJenisDokumen($value)
 * @method static Builder|FileUpload whereNamaLampiran($value)
 * @method static Builder|FileUpload wherePathFile($value)
 * @method static Builder|FileUpload whereTahun($value)
 * @method static Builder|FileUpload whereUpdatedAt($value)
 * @mixin Eloquent
 */
class FileUpload extends Model
{
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    protected $table = 'file_upload';
    protected $primaryKey = 'id_file_upload';
    protected $fillable = [
        'tahun',
        'id_kegiatan',
        'jenis_dokumen',
        'nama_lampiran'
    ];

    public const OTHER = [
        'sirup' => 'SIRUP'
    ];
    public const PENGADAAN_LANGSUNG = [
        'DPA' => 'Dokumen Pelaksanaan Anggaran',
        'KAK' => 'Kerangka Acuan Kerja',
        'RAB' => 'Rencana Anggaran Biaya',
        'HPS' => 'Harga Perkiraan Sendiri',
        'BOQ' => 'Bill Of Quantity',
        'PL' => 'Permohonan PL',
        'BA' => 'BA Hasil PL',
        'SPPH' => 'Surat Permintaan Permohonan Harga',
        'SPPBJ' => 'Surat Penunjukan Penyedia Barang dan Jasa',
        'KONTRAK' => 'KONTRAK',
        'SSUK' => 'SSUK atau SSKK',
        'SPP' => 'SPP atau SPMK',
        'ADDENDUM' => 'Addendum Kontrak',
        'PERMOHONAN_PEMERIKSAAN' => 'Permohonan Pemeriksaan Penyedia',
        'BAPHP' => 'BAPHP',
        'BAST' => 'BAST',
        'PERMOHONAN_PEMBAYARAN' => 'Permohonan Pembayaran Penyedia',
        'DELIVERY_ORDER' => 'Delivery Order',
        'INVOICE' => 'Invoice',
        'E_FAKTUR' => 'E-Faktur',
        'LAPORAN_PPK' => 'Laporan PPK',
        'BAST_PPK' => 'BAST PPK'
    ];

    public const E_KATALOG = [
        'DPA' => 'Dokumen Pelaksanaan Anggaran',
        'KAK' => 'Kerangka Acuan Kerja',
        'RAB' => 'Rencana Anggaran Biaya',
        'BOQ' => 'Bill Of Quantity',
        'NEGOISASI' => 'Hasil Negoisasi E-katalog',
        'SPPBJ' => 'Surat Penunjukan Penyedia Barang dan Jasa',
        'KONTRAK' => 'KONTRAK',
        'SSUK' => 'SSUK atau SSKK',
        'SPP' => 'SPP atau SPMK',
        'ADDENDUM' => 'Addendum Kontrak',
        'PERMOHONAN_PEMERIKSAAN' => 'Permohonan Pemeriksaan Penyedia',
        'BAPHP' => 'BAPHP',
        'BAST' => 'BAST',
        'PERMOHONAN_PEMBAYARAN' => 'Permohonan Pembayaran Penyedia',
        'DELIVERY_ORDER' => 'Delivery Order',
        'INVOICE' => 'Invoice',
        'E_FAKTUR' => 'E-Faktur',
        'LAPORAN_PPK' => 'Laporan PPK',
        'BAST_PPK' => 'BAST PPK'
    ];

    public const TENDER = [
        'DPA' => 'Dokumen Pelaksanaan Anggaran',
        'KAK' => 'Kerangka Acuan Kerja',
        'SPPH' => 'Surat Permintaan Permohonan Harga',
        'RAB' => 'Rencana Anggaran Biaya',
        'HPS' => 'Harga Perkiraan Sendiri',
        'BOQ' => 'Bill Of Quantity',
        'TENDER' => 'Permohonan Tender',
        'BA' => 'BA Hasil Tender',
        'SPPBJ' => 'Surat Penunjukan Penyedia Barang dan Jasa',
        'KONTRAK' => 'KONTRAK',
        'SSUK' => 'SSUK atau SSKK',
        'SPP' => 'SPP atau SPMK',
        'JAMINAN' => 'Jaminan Pelaksanaan',
        'ADDENDUM' => 'Addendum Kontrak',
        'PERMOHONAN_PEMERIKSAAN' => 'Permohonan Pemeriksaan Penyedia',
        'BAPHP' => 'BAPHP',
        'BAST' => 'BAST',
        'PERMOHONAN_PEMBAYARAN' => 'Permohonan Pembayaran Penyedia',
        'DELIVERY_ORDER' => 'Delivery Order',
        'INVOICE' => 'Invoice',
        'E_FAKTUR' => 'E-Faktur',
        'LAPORAN_PPK' => 'Laporan PPK',
        'BAST_PPK' => 'BAST PPK'
    ];
}
