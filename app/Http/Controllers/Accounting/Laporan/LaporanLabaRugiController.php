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
        $laporan = Laporanlabarugi::where('status_aktif', 'Aktif')->get();
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
            'periode_awal'=> Carbon::create($request->periode_awal)->startOfMonth(), 
            'periode_akhir'=> Carbon::create($request->periode_akhir)->endOfMonth(),
            'id_bengkel' => $request['id_bengkel'] = Auth::user()->id_bengkel,
            'status_aktif' => 'Tidak Aktif'
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

        $jurnalpengeluaran = Jurnalpengeluaran::whereDate('tanggal_jurnal', '>=', $laporan->periode_awal)
        ->whereDate('tanggal_jurnal', '<=', $laporan->periode_akhir)->get();

        
       

        // Carbon::('tanggal_jurnal')->format('j F Y');
        // {{ date('jS F Y',strtotime('tanggal_jurnal')) }};

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
    public function update(Request $request, $id_laporan)
    {
        $laporan = Laporanlabarugi::find($id_laporan);
        $laporan->kode_laporan = $request->kode_laporan;
        $laporan->pendapatan_jasa = $request->pendapatan_jasa;
        $laporan->pendapatan_penjualan = $request->pendapatan_penjualan;
        $laporan->pendapatan_penjualan_online = $request->pendapatan_penjualan_online;
        $laporan->total_pendapatan = $request->total_pendapatan;
        $laporan->beban_harga_pokok_penjualan = $request->beban_harga_pokok_penjualan;
        $laporan->total_laba_kotor = $request->total_laba_kotor;
        $laporan->beban_gaji = $request->beban_gaji;
        $laporan->beban_pph21 = $request->beban_pph21;
        $laporan->beban_pajak = $request->beban_pajak;
        $laporan->total_beban = $request->total_beban;
        $laporan->total_laba_bersih = $request->total_laba_bersih;
        $laporan->pendapatan_lainnya = $request->pendapatan_lainnya;
        $laporan->beban_lainnya = $request->beban_lainnya;
        $laporan->grand_total = $request->grand_total;
        $laporan->status_aktif = 'Aktif';
        
        if($laporan->grand_total <= 0){
            $laporan->status_laporan = 'Rugi';
        }else{
            $laporan->status_laporan = 'Laba';
        }


        

        $laporan->update();
       
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $laporan = Laporanlabarugi::find($id);
        $laporan->delete();

        return redirect()->back()->with('messagehapus','Data Laporan Laba Rugi Berhasil Terhapus');
    }

    public function CetakLaporan($id)
    {
        $laporan = Laporanlabarugi::find($id);
        return view('print.Accounting.cetak-laporan', compact('laporan'));
    }
}
