<?php

namespace App\Model\Accounting;

use App\Model\Accounting\Jurnal\Jurnalpenerimaan;
use App\Model\Accounting\Jurnal\Jurnalpengeluaran;
use App\Scopes\OwnershipScope;
use Illuminate\Database\Eloquent\Model;

class LaporanlabarugiDetail extends Model
{
    protected $table = "tb_accounting_detlaporan_laba_rugi";

    protected $primaryKey = 'id_detlaporan';

    protected $fillable = [
        'id_laporan',
        'transaksi',
        'jumlah_transaksi',
        'kelompok_transaksi'
    ];

    protected $hidden =[ 
       
    ];

    public $timestamps = false;
}
