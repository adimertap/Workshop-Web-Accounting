<?php

namespace App\Http\Controllers\Accounting\Laporan;

use App\Http\Controllers\Controller;
use App\Model\Accounting\Jurnal\Jurnalpenerimaan;
use App\Model\Accounting\Jurnal\Jurnalpengeluaran;
use App\Model\Accounting\Laporanlabarugi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanLabaRugiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laporan = Laporanlabarugi::all();
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');
        $tahun_periode = Carbon::now()->format('Y');

        return view('pages.accounting.laporan.laporanlabarugi', compact('laporan','today','tanggal','tahun_periode'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         
         $laporan = Laporanlabarugi::create([
            'periode_awal'=>$request->periode_awal,
            'periode_akhir'=>$request->periode_akhir,
            'id_bengkel' => $request['id_bengkel'] = Auth::user()->id_bengkel
        ]);
        
        return $laporan;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $laporan = Laporanlabarugi::find($id);

        $jurnalpengeluaran = Jurnalpengeluaran::where('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->where('tanggal_jurnal', '<=', $laporan->periode_akhir)->get();

        // PENGELUARAN
        $invoice = Jurnalpengeluaran::where('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->where('tanggal_jurnal', '<=', $laporan->periode_akhir)->where('jenis_jurnal','=','Invoice Payable')->sum('grand_total');

        $prf = Jurnalpengeluaran::where('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->where('tanggal_jurnal', '<=', $laporan->periode_akhir)->where('jenis_jurnal','=','Prf')->sum('grand_total');

        $gajikaryawan = Jurnalpengeluaran::where('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->where('tanggal_jurnal', '<=', $laporan->periode_akhir)->where('jenis_jurnal','=','Gaji_Karyawan')->sum('grand_total');
        
        $pajak = Jurnalpengeluaran::where('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->where('tanggal_jurnal', '<=', $laporan->periode_akhir)->where('jenis_jurnal','=','Pajak')->sum('grand_total');

        $pph21 = Jurnalpengeluaran::where('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->where('tanggal_jurnal', '<=', $laporan->periode_akhir)->where('jenis_jurnal','=','Pajak Karyawan')->sum('grand_total');


        // PENERIMAAN
        $jurnalpenerimaan = Jurnalpenerimaan::where('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->where('tanggal_jurnal', '<=', $laporan->periode_akhir)->get();

        $service = Jurnalpenerimaan::where('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->where('tanggal_jurnal', '<=', $laporan->periode_akhir)->where('jenis_jurnal','=','Transaksi Service')->sum('grand_total');

        $penjualanonsite = Jurnalpenerimaan::where('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->where('tanggal_jurnal', '<=', $laporan->periode_akhir)->where('jenis_jurnal','=','Transaksi Penjualan Sparepart')->sum('grand_total');

        $penjualanonline = Jurnalpenerimaan::where('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->where('tanggal_jurnal', '<=', $laporan->periode_akhir)->where('jenis_jurnal','=','Transaksi Marketplace')->sum('grand_total');

        // KODE GENERATE OTOMATIS
        $awal = $laporan->periode_awal;
        $id = Laporanlabarugi::getId();
        foreach($id as $value);
        $idlama = $value->id_laporan;
        $idbaru = $idlama + 1;
        $blt = date('y-m');

        $kode_laporan = 'LB/'.$awal.'/'.$idbaru;
        
        return view('pages.accounting.laporan.create',
            compact('kode_laporan','jurnalpengeluaran','jurnalpenerimaan',
            'laporan','invoice','prf','gajikaryawan','pajak','pph21',
            'service','penjualanonsite','penjualanonline'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
