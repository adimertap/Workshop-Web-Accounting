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
                        <div class="page-header-subtitle">Create Data Laporan Laba Rugi Kode {{ $kode_laporan }}</div>
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
                            aria-controls="tes" aria-selected="false">Pendapatan/Beban Lainnya</a></li>


                </ul>
            </div>
            <div class="card-body">
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
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Start date: activate to sort column ascending"
                                                        style="width: 20px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($jurnalpengeluaran as $item)
                                                <tr id="jurnalpengeluaran-{{ $item->id_jurnal_pengeluaran }}" role="row" class="odd">
                                                    <th scope="row" class="small" class="sorting_1">
                                                        {{ $loop->iteration}}.</th>
                                                    <td class="tanggal_jurnal_pengeluaran">{{ $item->tanggal_jurnal }}</td>
                                                    <td class="jenis_jurnal_pengeluaran">
                                                        @if ($item->jenis_jurnal == 'Gaji_Karyawan')
                                                            Gaji Karyawan
                                                        @elseif ($item->jenis_jurnal == 'Prf')
                                                            Prf
                                                        @elseif ($item->jenis_jurnal == 'Invoice_Payable')
                                                            Invoice
                                                        @elseif ($item->jenis_jurnal == 'Pajak')
                                                            Pajak
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
                                                    <td class="text-center">
                                                        <button class="btn btn-success btn-datatable"
                                                            onclick="tambahpengeluaran(event, {{ $item->id_jurnal_pengeluaran }})"
                                                            type="button" data-dismiss="modal"><i
                                                                class="fas fa-plus"></i>
                                                        </button>
                                                    </td>
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
                                                        style="width: 120px;">Jumlah</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Start date: activate to sort column ascending"
                                                        style="width: 20px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($jurnalpenerimaan as $item)
                                                <tr role="row" class="odd">
                                                    <th scope="row" class="small" class="sorting_1">
                                                        {{ $loop->iteration}}.</th>
                                                    <td>{{ $item->tanggal_jurnal }}</td>
                                                    <td>{{ $item->jenis_jurnal }}</td>
                                                    <td>{{ $item->Jenistransaksi->nama_transaksi}} tanggal
                                                        {{ date('j F, Y', strtotime($item->tanggal_transaksi)) }}</td>
                                                    <td>Rp. {{ number_format($item->grand_total,2,',','.') }}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-success btn-datatable"
                                                            onclick="tambahpenerimaan(event, {{ $item->id_jurnal_penerimaan }})"
                                                            type="button" data-dismiss="modal"><i
                                                                class="fas fa-plus"></i>
                                                        </button>
                                                    </td>
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
            </div>
        </div>

        <h4 class="mb-0 mt-5">Laporan Laba Rugi</h4>
        <hr class="mt-2 mb-4">

        {{------------------------------- PRINT ---------------------------------}}
        <a class="card-waves card lift lift-sm h-100" href="knowledge-base-category.html">
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
                        Rp. <span id="pendapatan_jasa">{{ $service }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Pendapatan Penjualan On-Site
                    </div>
                    <div class="col-5 col-xl-auto">
                        Rp. <span id="pendapatan_onsite">{{ $penjualanonsite }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Pendapatan Penjualan Online
                    </div>
                    <div class="col-5 col-xl-auto">
                        Rp. <span id="pendapatan_online">{{ $penjualanonline }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Total Pendapatan
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        Rp. <span id="total_pendapatan">0</span>
                    </h6>
                </div>

                {{-- HPP ----------------------------------------------------------------------------------------------------}}
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-12 col-xl-auto">
                        Harga Pokok Penjualan (Beban)
                    </h6>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Harga Pokok Penjualan
                    </div>
                    <div class="col-5 col-xl-auto">
                        Rp. <span id="harga_pokok_penjualan">{{ $prf + $invoice }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Total Harga Pokok Penjualan
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        Rp. <span id="total_harga_pokok_penjualan">0</span>
                    </h6>
                </div>

                {{-- TOTAL LABA KOTOR -----------------------------------------------------------------------------------------}}
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Total Laba Kotor
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        Rp. <span id="total_laba_kotor">0</span>
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
                        Biaya Gaji
                    </div>
                    <div class="col-5 col-xl-auto">
                        Rp. <span id="beban_gaji">{{ $gajikaryawan }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Biaya Pajak Penghasilan
                    </div>
                    <div class="col-5 col-xl-auto">
                        Rp. <span id="beban_pajak_penghasilan">{{ $pph21 }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-15">
                    <div class="col-7 col-xl-auto">
                        Biaya Pajak
                    </div>
                    <div class="col-5 col-xl-auto">
                        Rp. <span id="beban_pajak">{{ $pajak }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Total Beban Operasional
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        Rp. <span id="total_beban">0</span>
                    </h6>
                </div>

                {{-- LABA BERSIH OPERASIONAL --}}
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Laba Bersih Operasional
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        Rp. <span id="laba_bersih_operasional">0</span>
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
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        Total Pendapatan dan Beban Lainnya
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        Rp. <span>0</span>
                    </h6>
                </div>

                {{-- LABA RUGI BERSIH --}}
                <hr class="mr-10 ml-10 mt-5">
                <div class="row align-items-center justify-content-between ml-10 mr-15">
                    <h6 class="col-7 col-xl-auto text-primary">
                        LABA/(RUGI) BERSIH
                    </h6>
                    <h6 class="col-5 col-xl-auto text-primary">
                        Rp. <span id="fix_laba_rugi">0</span>
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
            <form action="{{ route('Rcv.store') }}" method="POST" id="form1" class="d-inline">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="small mb-1 mr-1" for="kelompok_transaksi">Kelompok Transaksi</label><span
                            class="mr-4 mb-3" style="color: red">*</span>
                        <select name="kelompok_transaksi" id="kelompok_transaksi" class="form-control"
                            class="form-control @error('kelompok_transaksi') is-invalid @enderror">
                            <option value="{{ old('kelompok_transaksi')}}"> Pilih Kelompok Transaksi</option>
                            <option value="Pendapatan">Pendapatan</option>
                            <option value="Beban">Beban</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1 mr-1" for="nama_transaksi">Nama Transaksi</label><span
                            class="mr-4 mb-3" style="color: red">*</span>
                        <input class="form-control" id="nama_transaksi" type="text" name="nama_transaksi"
                            placeholder="Input Nama Transaksi" value="{{ old('nama_transaksi') }}">
                    </div>
                    <div class="form-group">
                        <label class="small mb-1 mr-1" for="jumlah_transaksi">Jumlah Transaksi</label><span
                            class="mr-4 mb-3" style="color: red">*</span>
                        <input class="form-control" id="jumlah_transaksi" type="text" name="jumlah_transaksi"
                            placeholder="Input Jumlah Transaksi" value="{{ old('jumlah_transaksi') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" onclick="tambahdatalainnya(event)"
                        type="button">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
     function tambahpengeluaran(event, id_jurnal_pengeluaran) {
        var data = $('#jurnalpengeluaran-' + id_jurnal_pengeluaran)
        var tanggal_jurnal = $(data.find('.tanggal_jurnal_pengeluaran')[0]).text()
        var jenis_jurnal = $(data.find('.jenis_jurnal_pengeluaran')[0]).text()
        var total_pengeluaran = $(data.find('.grand_total_pengeluaran')[0]).text()
        

        console.log(tanggal_jurnal, jenis_jurnal, total_pengeluaran)


     }






    $(document).ready(function () {
        $('#dataTablePengeluaran').DataTable();
        $('#dataTablePenerimaan').DataTable();
    });

</script>

@endsection
