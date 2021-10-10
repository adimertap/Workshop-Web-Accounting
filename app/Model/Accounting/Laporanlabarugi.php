<?php

namespace App\Model\Accounting;

use App\Model\Accounting\Jurnal\Jurnalpengeluaran;
use App\Scopes\OwnershipScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Laporanlabarugi extends Model
{
    use SoftDeletes;

    protected $table = "tb_accounting_laporan_laba_rugi";

    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_bengkel',
        'kode_laporan',
        'periode_awal',
        'periode_akhir',
        'total_pendapatan',
        'total_beban',
        'total_laba',
        'total_rugi',
        'status_laporan'
    ];

    protected $hidden =[ 
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function Detail()
    {
        return $this->hasMany(LaporanlabarugiDetail::class, 'id_laporan');
    }

    protected static function booted()
    {
        static::addGlobalScope(new OwnershipScope);
    }

    public static function getId()
    {
        $getId = DB::table('tb_accounting_laporan_laba_rugi')->orderBy('id_laporan', 'DESC')->take(1)->get();
        if (count($getId) > 0) return $getId;
        return (object)[
            (object)[
                'id_laporan' => 0
            ]
        ];
    }

}
