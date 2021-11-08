@extends('layouts.Admin.adminaccounting')

@section('content')
{{-- HEADER --}}


<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary mb-4">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h2 class="page-header-title">
                            <div class="page-header-icon">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            Laporan Laba Rugi
                        </h2>
                        <div class="page-header-subtitle">Create Data Laporan Laba Rugi Kode <span id="kode_laporan"> {{ $kode_laporan }}</span></div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">
                        <div class="row input-daterange">
                            <div class="col-md-6">
                                <label class="small">Start Date</label>
                                <div class="input-group input-group-joined">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="color: gray">
                                            <i data-feather="search"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="from_date" value="{{ $laporan->periode_awal }}"
                                        class="form-control form-control-sm" placeholder="From Date" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="small">End Date</label>
                                <div class="input-group input-group-joined">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i data-feather="search"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="to_date" value="{{ $laporan->periode_akhir }}"
                                        class="form-control form-control-sm" placeholder="To Date" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main page content-->
    <div class="container">
        <h4 class="mb-0 mt-5">Daftar Jurnal Pengeluaran dan Penerimaan</h4>
        <hr class="mt-2 mb-4">

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills" id="cardPill" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="overview-pill" href="#overviewPill"
                            data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Jurnal
                            Pengeluaran</a></li>
                    <li class="nav-item"><a class="nav-link" id="example-pill" href="#examplePill" data-toggle="tab"
                            role="tab" aria-controls="example" aria-selected="false">Jurnal Penerimaan</a></li>
                    <li class="nav-item"><a class="nav-link" data-target="#Modaltambah" data-toggle="modal" role="tab"
                            aria-controls="tes" aria-selected="false">Tambah Pendapatan/Beban Lainnya</a></li>


                </ul>
            </div>
            <div class="card-body">
                <form action="{{ route('laporan-laba-rugi.store') }}" id="form2" method="POST">
                @csrf
                <div class="tab-content" id="cardPillContent">
                    <div class="tab-pane fade show active" id="overviewPill" role="tabpanel"
                        aria-labelledby="overview-pill">
                        <div class="datatable">
                            @if(session('messageberhasil'))
                            <div class="alert alert-success" role="alert"> <i class="fas fa-check"></i>
                                {{ session('messageberhasil') }}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @endif
                            @if(session('messagebayar'))
                            <div class="alert alert-success" role="alert"> <i class="fas fa-check"></i>
                                {{ session('messagebayar') }}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @endif

                            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-hover dataTable"
                                            id="dataTablePengeluaran" width="100%" cellspacing="0" role="grid"
                                            aria-describedby="dataTable_info" style="width: 100%;">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending"
                                                        style="width: 10px;">
                                                        No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 40px;">Tanggal</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 80px;">Jenis Jurnal</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 290px;">Keterangan</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 130px;">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody id="pengeluaran">
                                                @forelse ($jurnalpengeluaran as $item)
                                                <tr id="jurnalpengeluaran-{{ $item->id_jurnal_pengeluaran }}" role="row" class="odd">
                                                    <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}.</th>
                                                    <td class="tanggal_jurnal_pengeluaran" id="{{ $item->id_jurnal_pengeluaran }}">{{ $item->tanggal_jurnal }}</td>
                                                    <td class="jenis_jurnal_pengeluaran">
                                                        @if ($item->jenis_jurnal == 'Gaji_Karyawan')
                                                            Gaji Karyawan
                                                        @elseif ($item->jenis_jurnal == 'Prf')
                                                            Prf
                                                        @elseif ($item->jenis_jurnal == 'Invoice_Payable')
                                                            Invoice
                                                        @elseif ($item->jenis_jurnal == 'Pajak')
                                                            Pajak
                                                        @elseif ($item->jenis_jurnal == 'Pajak Karyawan')
                                                            PPh21
                                                        @endif
                                                    </td>
                                                    <td class="keterangan_jurnal_pengeluaran">
                                                        @if ($item->jenis_jurnal == 'Gaji_Karyawan')
                                                        {{ $item->Jenistransaksi->nama_transaksi}} bulan
                                                        {{ $item->kode_transaksi }}, tanggal
                                                        {{ date('j F, Y', strtotime($item->tanggal_transaksi)) }}
                                                        @else
                                                        {{ $item->Jenistransaksi->nama_transaksi}} tanggal
                                                        {{ date('j F, Y', strtotime($item->tanggal_transaksi)) }}
                                                        @endif
                                                    </td>
                                                    <td class="grand_total_pengeluaran">Rp. {{ number_format($item->grand_total,2,',','.') }}</td>
                                                    @empty

                                                    @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="examplePill" role="tabpanel" aria-labelledby="example-pill">
                        <div class="datatable">
                            @if(session('messageberhasil'))
                            <div class="alert alert-success" role="alert"> <i class="fas fa-check"></i>
                                {{ session('messageberhasil') }}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @endif
                            @if(session('messagebayar'))
                            <div class="alert alert-success" role="alert"> <i class="fas fa-check"></i>
                                {{ session('messagebayar') }}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @endif

                            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-hover dataTable"
                                            id="dataTablePenerimaan" width="100%" cellspacing="0" role="grid"
                                            aria-describedby="dataTable_info" style="width: 100%;">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending"
                                                        style="width: 10px;">
                                                        No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 20px;">Tanggal</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 80px;">Jenis Jurnal</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 200px;">Keterangan</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 100px;">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody id="penerimaan">
                                                @forelse ($jurnalpenerimaan as $item)
                                                <tr role="row" class="odd">
                                                    <th scope="row" class="small" class="sorting_1">
                                                        {{ $loop->iteration}}.</th>
                                                    <td id="{{ $item->id_jurnal_penerimaan }}">{{ $item->tanggal_jurnal }}</td>
                                                    <td>{{ $item->jenis_jurnal }}</td>
                                                    <td>{{ $item->Jenistransaksi->nama_transaksi}} tanggal
                                                        {{ date('j F, Y', strtotime($item->tanggal_transaksi)) }}</td>
                                                    <td>Rp. {{ number_format($item->grand_total,2,',','.') }}</td>
                                                    @empty
                                                    @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <h4 class="mb-0 mt-5">Laporan Laba Rugi</h4>
        <hr class="mt-2 mb-4">

        {{------------------------------- PRINT ---------------------------------}}
        <a class="card-waves card lift lift-sm h-100">
            <div class="card-body">
                <div class="text-center mb-4 mt-5">
                    <h1 class="card-title text-primary">Laporan Laba Rugi</h1>
                    <h4 class="card-text">Bengkel {{ Auth::user()->Bengkel->nama_bengkel }}</h4>
                    <h6 class="card-text">Periode laporan {{ date('j F, Y', strtotime($laporan->periode_awal)) }} sampai
                        {{ date('j F, Y', strtotime($laporan->periode_akhir)) }}</h6>
                </div>

                {{-- PENDAPATAN -----------------------------------------------------------------------------------------------}}
                <hr class="mt-2 mb-4">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-12 col-xl-auto">
                        Pendapatan
                    </h6>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Pendapatan Jasa
                    </div>
                    <div class="col-5 col-xl-auto">
                       <span id="pendapatan_jasa">Rp. {{ number_format($service,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Pendapatan Penjualan On-Site
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="pendapatan_onsite">Rp. {{ number_format($penjualanonsite,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Pendapatan Penjualan Online
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="pendapatan_online">Rp. {{ number_format($penjualanonline,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Total Pendapatan
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        <span id="total_pendapatan">Rp. {{ number_format($service + $penjualanonsite + $penjualanonline,2,',','.') }}</span>
                    </h6>
                </div>

                {{-- HPP ----------------------------------------------------------------------------------------------------}}
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-12 col-xl-auto">
                        Beban Harga Pokok Penjualan
                    </h6>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Harga Pokok Penjualan
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="harga_pokok_penjualan">Rp. {{ number_format($prf + $invoice,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Total Harga Pokok Penjualan
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        <span id="total_harga_pokok_penjualan">Rp. {{ number_format($prf + $invoice,2,',','.') }}</span>
                    </h6>
                </div>

                {{-- TOTAL LABA KOTOR -----------------------------------------------------------------------------------------}}
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Total Laba Kotor
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        <span id="total_laba_kotor">Rp. {{ number_format(($service + $penjualanonsite + $penjualanonline) - ($prf + $invoice),2,',','.') }}</span>
                    </h6>
                </div>

                {{-- BEBAN OPERASIONAL --------------------------------------------------------------------------------------}}
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-12 col-xl-auto">
                        Beban Operasional
                    </h6>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Biaya Gaji Pegawai
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="beban_gaji">Rp. {{ number_format($gajikaryawan,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Biaya Pajak Penghasilan
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="beban_pajak_penghasilan">Rp. {{ number_format($pph21,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Biaya Pajak
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="beban_pajak">Rp. {{ number_format($pajak,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Total Beban Operasional
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        <span id="total_beban">Rp. {{ number_format($pph21 + $pajak + $gajikaryawan,2,',','.') }}</span>
                    </h6>
                </div>

                {{-- LABA BERSIH OPERASIONAL --}}
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Laba Bersih Operasional
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        <span id="laba_bersih_operasional">Rp. {{ number_format((($service + $penjualanonsite + $penjualanonline) - ($prf + $invoice))-($pph21 + $pajak + $gajikaryawan) ,2,',','.') }}</span>
                    </h6>
                </div>

                {{-- Pendapatan Atau Beban Lainnya --}}
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-12 col-xl-auto">
                        Pendapatan atau Beban Lainnya
                    </h6>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Pendapatan Lainnya
                        
                    </div>
                    <div class="col-5 col-xl-auto">
                        Rp. <span id="pendapatanlainnya">{{ $laporan->pendapatan_lainnya ?? '' }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Beban Lainnya
                    </div>
                    <div class="col-5 col-xl-auto">
                        Rp. <span id="bebanlainnya">{{ $laporan->beban_lainnya ?? '' }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                       
                    </div>
                    <div class="col-5 col-xl-auto">
                        <u type="button" class="small text-primary" onclick="reset(event)" style="color: gray">reset</u>
                    </div>
                </div>
               
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        LABA/(RUGI) BERSIH
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        <span id="grand_total">Rp {{ number_format((($service + $penjualanonsite + $penjualanonline) - ($prf + $invoice))-($pph21 + $pajak + $gajikaryawan) ,2,',','.') }}</span>
                    </h6>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-2 col-xl-auto text-primary">
                        
                    </h6>
                    <h6 class="col-10 col-xl-auto text-primary">
                        <button class="btn-sm btn-primary" onclick="simpanlaporan(event,{{ $laporan }}, {{ $laporan->id_laporan }})" type="button" >Simpan Laporan</button>
                    </h6>
                </div>
            </div>
            <div class="card-footer">
                <div class="small text-muted">Status Laporan (LABA/RUGI)</div>
            </div>
        </a>
    </div>
</main>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="Modaltambah" tabindex="-1" role="dialog" data-backdrop="static"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Pendapatan / Beban Lainnya</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="" method="POST" id="form1" class="d-inline">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="small mb-1 mr-1" for="kelompok_transaksi">Kelompok Transaksi</label><span
                            class="mr-4 mb-3" style="color: red">*</span>
                        <select name="kelompok_transaksi" id="kelompok_transaksi" class="form-control"
                            class="form-control @error('kelompok_transaksi') is-invalid @enderror">
                            <option value="{{ old('kelompok_transaksi')}}">Pilih Kelompok Transaksi</option>
                            <option value="Pendapatan Lainnya">Pendapatan Lainnya</option>
                            <option value="Beban Lainnya">Beban Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1 mr-1" for="jumlah_transaksi">Jumlah Transaksi</label><span
                            class="mr-4 mb-3" style="color: red">*</span>
                        <input class="form-control jumlah_transaksi" id="jumlah_transaksi" type="text" name="jumlah_transaksi"
                            placeholder="Input Jumlah Transaksi" value="{{ old('jumlah_transaksi') }}">
                        <div class="small text-primary">Detail Jumlah (IDR) :
                            <span id="detailjumlahtransaksi"
                                class="detailjumlahtransaksi">0</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" onclick="tambahdatalainnya(event)" type="button" data-dismiss="modal">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function tambahdatalainnya(event) {
        var form = $('#form1')
        var _token = form.find('input[name="_token"]').val()
        var kelompok_transaksi = $('#kelompok_transaksi').val()
        var jumlah_transaksi = form.find('input[name="jumlah_transaksi"]').val()
        var jumlah_transaksi_fix = new Intl.NumberFormat('id', {
            style: 'currency',
            currency: 'IDR'
        }).format(jumlah_transaksi)

        if (kelompok_transaksi == 'Pilih Kelompok Transaksi' | jumlah_transaksi == ''){
            alert('Terdapat Data Kosong')
        }else{
                if(kelompok_transaksi == 'Pendapatan Lainnya'){
                var elementpendapatan = $('#pendapatanlainnya').html()
                var pendapatanlainnya = parseInt(jumlah_transaksi) + parseInt(elementpendapatan)
                $('#pendapatanlainnya').html(pendapatanlainnya)
                var elementgrand = $('#grand_total').html()
                var grandtotal = parseInt(elementgrand.split('Rp')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '')
                .trim())
                var grand_total_fix = grandtotal + parseInt(jumlah_transaksi)
                $('#grand_total').html(new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(grand_total_fix))

            }else if(kelompok_transaksi == 'Beban Lainnya'){
                var elementbeban = $('#bebanlainnya').html()
                var bebanlainnya =  parseInt(jumlah_transaksi) + parseInt(elementbeban)
                $('#bebanlainnya').html(bebanlainnya)

                var elementgrand = $('#grand_total').html()
                var grandtotal = parseInt(elementgrand.split('Rp')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '')
                .trim())
                var grand_total_fix = grandtotal - parseInt(jumlah_transaksi)
                $('#grand_total').html(new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(grand_total_fix))
            }else{
                alert('Anda Belum Memilih Kelompok Transaksi')
            }
        }
    }

    function reset(event) {
        if($('#pendapatanlainnya').html() != 0 | $('#bebanlainnya').html() != 0 ){
            a = 0
            var pendapatan = $('#pendapatanlainnya').html()
            var beban = $('#bebanlainnya').html()
            var elementgrand = $('#grand_total').html()
            var grandtotal = parseInt(elementgrand.split('Rp')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '')
                    .trim())
            var grand_total_pendapatan = grandtotal - parseInt(pendapatan)
            var grand_total_fix = grand_total_pendapatan + parseInt(beban)
            
            $('#grand_total').html(new Intl.NumberFormat('id', {
                style: 'currency',
                currency: 'IDR'
            }).format(grand_total_fix))
         
            $('#pendapatanlainnya').html(a)
            $('#bebanlainnya').html(a)

        }else{
            window.alert('Gagal Reset')
        }
    }


    function simpanlaporan(event, laporan, id_laporan){
        console.log(laporan)
        var kode_laporan = $('#kode_laporan').html()
        var form = $('#form2')
        var _token = form.find('input[name="_token"]').val()
        var pendapatan_jasa = $('#pendapatan_jasa').html()
        var pendapatan_jasa1 = parseInt(pendapatan_jasa.split('Rp.')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var pendapatan_onsite = $('#pendapatan_onsite').html()
        var pendapatan_onsite1 = parseInt(pendapatan_onsite.split('Rp.')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var pendapatan_online = $('#pendapatan_online').html()
        var pendapatan_online1 = parseInt(pendapatan_online.split('Rp.')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var total_pendapatan = $('#total_pendapatan').html()
        var total_pendapatan1 = parseInt(total_pendapatan.split('Rp.')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var harga_pokok_penjualan = $('#harga_pokok_penjualan').html()
        var harga_pokok_penjualan1 = parseInt(harga_pokok_penjualan.split('Rp')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var total_laba_kotor = $('#total_laba_kotor').html()
        var total_laba_kotor1 = parseInt(total_laba_kotor.split('Rp.')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var beban_gaji = $('#beban_gaji').html()
        var beban_gaji1 = parseInt(beban_gaji.split('Rp.')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var beban_pajak_penghasilan = $('#beban_pajak_penghasilan').html()
        var beban_pajak_penghasilan1 = parseInt(beban_pajak_penghasilan.split('Rp.')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var beban_pajak = $('#beban_pajak').html()
        var beban_pajak1 = parseInt(beban_pajak.split('Rp.')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var total_beban = $('#total_beban').html()
        var total_beban1 = parseInt(total_beban.split('Rp.')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var laba_bersih_operasional = $('#laba_bersih_operasional').html()
        var laba_bersih_operasional1 = parseInt(laba_bersih_operasional.split('Rp.')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var pendapatanlainnya = $('#pendapatanlainnya').html()
        var bebanlainnya = $('#bebanlainnya').html()
        var grand_total = $('#grand_total').html()
        var grand_total1 = parseInt(grand_total.split('Rp')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim())

        var datapengeluaran = $('#pengeluaran').children()
        for (let index = 0; index < datapengeluaran.length; index++) {
            var children_pengeluaran = $(datapengeluaran[index]).children()
            var td_pengeluaran = children_pengeluaran[1]
            var span_pengeluaran = $(td_pengeluaran).children()[0]
            var id_jurnal_pengeluaran = $(span_pengeluaran).attr('id')

            console.log(id_jurnal_pengeluaran)


        }

        var datapenerimaan = $('#penerimaan').children()
        for (let index = 0; index < datapenerimaan.length; index++) {
            var children_penerimaan = $(datapenerimaan[index]).children()
            var td_penerimaan = children_penerimaan[1]
            var span_penerimaan = $(td_penerimaan).children()[0]
            var id_jurnal_penerimaan = $(span_penerimaan).attr('id')

            console.log(id_jurnal_penerimaan)

        }





        var data = {
                _token: _token,
                kode_laporan: kode_laporan,
                pendapatan_jasa: pendapatan_jasa1,
                pendapatan_penjualan: pendapatan_onsite1,
                pendapatan_penjualan_online: pendapatan_online1,
                total_pendapatan: total_pendapatan1,
                beban_harga_pokok_penjualan: harga_pokok_penjualan1,
                total_laba_kotor: total_laba_kotor1,
                beban_gaji: beban_gaji1,
                beban_pph21: beban_pajak_penghasilan1,
                beban_pajak: beban_pajak1,
                total_beban: total_beban1,
                total_laba_bersih: laba_bersih_operasional1,
                pendapatan_lainnya: pendapatanlainnya,
                beban_lainnya: bebanlainnya,
                grand_total: grand_total1,
            }
        
        $.ajax({
                method: 'put',
                url: '/Accounting/laporan-laba-rugi/' + id_laporan,
                data: data,
                success: function (response) {
                    // window.location.href = '/Accounting/laporan-laba-rugi'
                    console.log(response)

                },
                error: function (response) {
                    console.log(response)
                }
            });


    }





    $(document).ready(function () {
        $('.jumlah_transaksi').each(function () {
            $(this).on('input', function () {
                var harga = $(this).val()
                var harga_fix = new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(harga)

                var harga_paling_fix = $(this).parent().find('.detailjumlahtransaksi')
                $(harga_paling_fix).html(harga_fix);
            })
        })
        
        $('#dataTablePengeluaran').DataTable();
        $('#dataTablePenerimaan').DataTable();

        
    });

</script>

@endsection
