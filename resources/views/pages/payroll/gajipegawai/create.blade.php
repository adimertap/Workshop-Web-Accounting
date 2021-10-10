@extends('layouts.Admin.adminpayroll')

@section('content')
{{-- HEADER --}}
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon" style="color: white"><i class="fas fa-wallet"></i>
                            </div>
                            <div class="page-header-subtitle" style="color: white">Tambah Data Pembayaran Gaji Pegawai
                            </div>
                        </h1>
                        <div class="small">
                            <span class="font-weight-500">Gaji Pegawai</span>
                            · Tambah · Data
                            <span class="font-weight-500 text-primary" id="id_bengkel"
                                style="display:none">{{ Auth::user()->bengkel->id_bengkel}}</span>
                        </div>
                    </div>
                    <div class="col-12 col-xl-auto">
                        <a href="{{ route('gaji-pegawai.index') }}"
                            class="btn btn-sm btn-light text-primary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="alert alert-danger" id="alertdatakosong" role="alert" style="display:none"> <i
                    class="fas fa-times"></i>
                Error! Terdapat Data yang Masih Kosong!
                <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
    </header>

    <div class="container mt-n10">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">Detail Formulir Pegawai</div>
                    <div class="card-body">
                        <form action="{{ route('gaji-pegawai.update', $gaji->id_gaji_pegawai) }}" id="form1"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1 mr-1" for="tahun_gaji">Tahun Gaji</label><span
                                        class="mr-4 mb-3" style="color: red">*</span>
                                    <input class="form-control" id="tahun_gaji" type="text" name="tahun_gaji"
                                        placeholder="Input Tahun Gaji" value="{{ $gaji->tahun_gaji }}" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1 mr-1" for="bulan_gaji">Bulan Gaji</label><span
                                        class="mr-4 mb-3" style="color: red">*</span>
                                    <select name="bulan_gaji" id="bulan_gaji" class="form-control"
                                        class="form-control @error('bulan_gaji') is-invalid @enderror">
                                        <option value="{{ $gaji->bulan_gaji }}">{{ $gaji->bulan_gaji }}</option>
                                        <option value="Januari">Januari</option>
                                        <option value="Februari">Februari</option>
                                        <option value="Maret">Maret</option>
                                        <option value="April">April</option>
                                        <option value="Mei">Mei</option>
                                        <option value="Juni">Juni</option>
                                        <option value="Juli">Juli</option>
                                        <option value="Agustus">Agustus</option>
                                        <option value="September">September</option>
                                        <option value="Oktober">Oktober</option>
                                        <option value="November">November</option>
                                        <option value="Desember">Desember</option>
                                    </select>
                                    @error('bulan_gaji')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1 mr-1" for="id_jenis_transaksi">Jenis Transaksi</label><span
                                    class="mr-4 mb-3" style="color: red">*</span>
                                <input class="form-control" name="id_jenis_transaksi" id="id_jenis_transaksi"
                                    value="{{ $gaji->Jenistransaksi->nama_transaksi }}" readonly></input>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="gaji_diterima">Total Gaji Pokok</label>
                                <div class="input-group input-group-joined">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gray-200">
                                            Rp.
                                        </span>
                                    </div>
                                    <input class="form-control" id="total_gaji" type="text" name="gaji_diterima"
                                        placeholder="Keterangan Pembayaran"
                                        value="{{ $gaji->grand_total_gaji !=  null ? $gaji->grand_total_gaji : $gaji->grand_total_gaji }}"
                                        class="form-control @error('keterangan') is-invalid @enderror" readonly>
                                    @error('keterangan')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="gaji_diterima">Total Tunjangan</label>
                                <div class="input-group input-group-joined">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gray-200">
                                            Rp.
                                        </span>
                                    </div>
                                    <input class="form-control" id="total_tunjangan" type="text" name="gaji_diterima"
                                        placeholder="Keterangan Pembayaran" value="0"
                                        class="form-control @error('keterangan') is-invalid @enderror" readonly>
                                    @error('keterangan')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="gaji_diterima">Total Gaji Keseluruhan</label>
                                <div class="input-group input-group-joined">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gray-200">
                                            Rp.
                                        </span>
                                    </div>
                                    <input class="form-control" id="gaji_diterima" type="text" name="gaji_diterima"
                                        placeholder="Keterangan Pembayaran" value="0"
                                        class="form-control @error('keterangan') is-invalid @enderror" readonly>
                                    @error('keterangan')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="pph21">Total PPh21 Pegawai</label>
                                <div class="input-group input-group-joined">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gray-200">
                                            Rp.
                                        </span>
                                    </div>
                                    <input class="form-control" id="total_pph21" type="text" name="total_pph21"
                                        placeholder="Keterangan Pembayaran" value="0"
                                        class="form-control @error('keterangan') is-invalid @enderror" readonly>
                                    @error('keterangan')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" type="text" name="keterangan"
                                    placeholder="Keterangan Pembayaran"
                                    class="form-control @error('keterangan') is-invalid @enderror"></textarea>
                                @error('keterangan')<div class="text-danger small mb-1">{{ $message }}
                                </div> @enderror
                            </div>
                            <div class="form-group text-right">
                                <hr>
                                <a href="{{ route('laporanabsensi') }}" target="_blank" class="btn btn-secondary btn-sm"
                                    type="button">
                                    Absensi
                                </a>
                                <a href="" class="btn btn-sm btn-secondary" type="button" data-toggle="modal"
                                    data-target="#Modalpph21">
                                    Pph21
                                </a>
                                
                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                                    data-target="#Modalsumbit">Simpan Data</button>
                            </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="collapse show" id="collapseCardExample">
                        <div class="card-body">
                            <div class="datatable">
                                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered table-hover dataTable" id="dataTable"
                                                width="100%" cellspacing="0" role="grid"
                                                aria-describedby="dataTable_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                            rowspan="1" colspan="1" aria-sort="ascending"
                                                            aria-label="Name: activate to sort column descending"
                                                            style="width: 20px;">
                                                            No</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Position: activate to sort column ascending"
                                                            style="width: 150px;">Nama Pegawai</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Position: activate to sort column ascending"
                                                            style="width: 80px;">
                                                            Jabatan</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Position: activate to sort column ascending"
                                                            style="width: 30px;">
                                                            Status</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Position: activate to sort column ascending"
                                                            style="width: 100px;">
                                                            Gaji Pokok</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Position: activate to sort column ascending"
                                                            style="width: 50px;">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($pegawai as $item)
                                                    <tr role="row" class="odd">
                                                        <th scope="row" class="small" class="sorting_1">
                                                            {{ $loop->iteration}}.</th>
                                                        <td id="nama_pegawai-{{ $item->id_pegawai }}">
                                                            {{ $item->nama_pegawai}}</td>
                                                        <td id="jabatan-{{ $item->id_pegawai }}">
                                                            {{ $item->Jabatan->nama_jabatan}}</td>
                                                        <td id="ptkp-{{ $item->id_pegawai }}">
                                                                {{ $item->PTKP->nama_ptkp}}</td>
                                                        <td id="gajipokok-{{ $item->id_pegawai }}">
                                                            @if ($item->Jabatan->Gajipokok == null |
                                                            $item->Jabatan->Gajipokok == '' )
                                                            <button class="btn btn-xs btn-primary" type="button"
                                                                data-toggle="modal"
                                                                data-target="#Modaltambahgajipokok">Tambah Gaji
                                                                Pokok</button>
                                                            @else
                                                            Rp.{{ number_format($item->Jabatan->Gajipokok->besaran_gaji,2,',','.') }}

                                                            @endif

                                                        </td>
                                                        {{-- <td id="gajipokok-{{ $item->id_pegawai }}">Rp.{{ number_format($item->Jabatan->Gajipokok->besaran_gaji,2,',','.') }}
                                                        --}}
                                                        </td>
                                                        <td>
                                                            @if ($item->Jabatan->Gajipokok == null |
                                                            $item->Jabatan->Gajipokok =='')
                                                            <span class="small">Belum Ada Gaji Pokok</span>
                                                            @else
                                                            <button id="{{ $item->id_pegawai }}-button"
                                                                class="btn btn-success btn-xs" type="button"
                                                                data-toggle="modal"
                                                                data-target="#Modaltambah-{{ $item->id_pegawai }}">
                                                                Tambah
                                                            </button>
                                                            @endif

                                                        </td>
                                                    </tr>
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
                <p></p>
            </div>
        </div>
        <div class="card">
            <div class="card card-header-actions">
                <div class="card-header">
                    Detail Gaji Pegawai
                    {{-- <a href="" class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                        data-target="#Modaltambahtunjangan">
                        Tambah Tunjangan
                    </a> --}}
                </div>
                <div class="card-body">
                    <div class="datatable">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-hover dataTable" id="dataTableKonfirmasi"
                                        width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                        style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-sort="ascending"
                                                    aria-label="Name: activate to sort column descending"
                                                    style="width: 20px;">
                                                    No</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 150px;">
                                                    Nama Pegawai</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 80px;">
                                                    Jabatan</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 150px;">
                                                    Gaji Pokok</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 80px;">
                                                    Total Tunjangan</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 80px;">
                                                    Total Gaji</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 80px;">
                                                    Total PPh21</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 50px;">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id='konfirmasi'>
                                           
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
</main>

<div class="modal fade" id="Modalpph21" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="staticBackdropLabel">Aturan Pph21</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="datatable">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTable" width="100%"
                                    cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 30px;">No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 250px;">Nama Pph21</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 100px;">Kumulatif Tahunan</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 90px;">Besaran Pph21 (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pph21">
                                        @forelse ($pph21 as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">
                                                {{ $loop->iteration}}</th>
                                            <td>{{ $item->nama_pph21 }}</td>
                                            <td class="jumlah_pph21">Rp.
                                                {{ number_format($item->kumulatif_tahunan,2,',','.') }}</td>
                                            <td class="text-center">{{ $item->besaran_pph21 }}</td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modaltambahgajipokok" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Gaji Pokok tes</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('gaji-pokok.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="small mb-1">Isikan Form Dibawah Ini</label>
                    <hr>
                    </hr>
                    <div class="form-group">
                        <label class="small mb-1 mr-1" for="id_jabatan">Pilih Jabatan</label><span class="mr-4 mb-3"
                            style="color: red">*</span>
                        <select class="form-control" name="id_jabatan" id="id_jabatan"
                            class="form-control @error('id_jabatan') is-invalid @enderror">
                            <option>Pilih Jabatan</option>
                            @foreach ($jabatan as $item)
                            <option value="{{ $item->id_jabatan }}">{{ $item->nama_jabatan }}</option>
                            @endforeach
                        </select>
                        @error('id_jabatan')<div class="text-danger small mb-1">{{ $message }}
                        </div> @enderror
                    </div>
                    <div class="form-group">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                                <label class="small mb-1 mr-1" for="besaran_gaji">Besaran Gaji</label><span
                                    class="mr-4 mb-3" style="color: red">*</span>
                            </div>
                            <div class="col-12 col-lg-auto text-center text-lg-right">
                                <div class="small text-lg-right">
                                    <span class="font-weight-500 text-primary">Nominal : </span>
                                    <span id="detailbesarangaji"></span>
                                </div>
                            </div>
                        </div>
                        <input class="form-control" name="besaran_gaji" type="number" id="besaran_gaji"
                            placeholder="Input Besaran Gaji" value="{{ old('besaran_gaji') }}"
                            class="form-control @error('besaran_gaji') is-invalid @enderror" />
                        @error('besaran_gaji')<div class="text-danger small mb-1">{{ $message }}
                        </div> @enderror
                    </div>
                </div>

                {{-- Validasi Error --}}
                @if (count($errors) > 0)
                @endif

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="Submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

@forelse ($pegawai as $items)
<div class="modal fade" id="Modaltambah-{{ $items->id_pegawai }}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="staticBackdropLabel">Pilih Tunjangan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info alert-icon" role="alert">
                    <div class="alert-icon-aside">
                        <i class="far fa-check-square"></i>
                    </div>
                    <div class="alert-icon-content">
                        <h6 class="alert-heading">Tunjangan {{ $items->nama_pegawai }}</h6>
                        Pilih tunjangan dengan cara mencentang pada bagian pilih
                    </div>
                </div>
                <div class="small mb-2">
                    <span class="">Status Pegawai: <span class="small text-primary  font-weight-500">{{ $items->PTKP->nama_ptkp }}</span>,dengan besaran <span class="small text-primary  font-weight-500" id="besaran_ptkp-{{ $items->id_pegawai }}"> Rp.{{ number_format($items->PTKP->besaran_ptkp,2,',','.') }}</span></span>
                </div>
                <div class="form-group">
                    <div class="datatable">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-hover dataTable"
                                        id="dataTablesemuatunjangan" width="100%" cellspacing="0" role="grid"
                                        aria-describedby="dataTable_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-sort="ascending"
                                                    aria-label="Name: activate to sort column descending"
                                                    style="width: 20px;">
                                                    No</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 80px;">
                                                    Tunjangan</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 180px;">
                                                    Jumlah</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 180px;">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tunjangan-{{ $items->id_pegawai }}">
                                            @forelse ($tunjangan as $item)
                                            <tr id="item-{{ $item->id_tunjangan }}" role="row" class="odd">
                                                <th scope="row" class="small" class="sorting_1">
                                                    {{ $loop->iteration}}</th>
                                                <td class="nama_tunjangan">{{ $item->nama_tunjangan }}</td>
                                                <td class="jumlah_tunjangan">Rp
                                                    {{ number_format($item->jumlah_tunjangan,2,',','.') }}</td>
                                                </td>
                                                <td>
                                                    <div class="">
                                                        <input class="checktunjangan"
                                                            id="customCheck1-{{ $item->id_tunjangan }}"
                                                            type="checkbox" />
                                                        <label class="" for="customCheck1">Pilih</label>
                                                    </div>
                                                </td>
                                            </tr>
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
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm text-right"
                    onclick="tambahtunjangan(event, {{ $items->id_pegawai }})" type="button" data-dismiss="modal">Tambah
                    Tunjangan</button>
            </div>
        </div>
    </div>
</div>

@empty

@endforelse

<div class="modal fade" id="Modalsumbit" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success-soft">
                <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Pembayaran Gaji</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group text-center">Apakah Form yang Anda inputkan sudah benar?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary"
                    onclick="tambahgaji(event,{{ $tunjangan }},{{ $gaji->id_gaji_pegawai }})">Ya Sudah!</button>
            </div>
        </div>
    </div>
</div>





<template id="template_delete_button">
    <button class="btn btn-danger btn-datatable" onclick="hapusgaji(this)" type="button">
        <i class="fas fa-trash"></i>
    </button>
    {{-- <button class="btn btn-primary btn-datatable" onclick="editgaji(this)" type="button">
        <i class="fas fa-edit"></i>
    </button> --}}
</template>

<template id="template_add_button">
    <button class="btn btn-success btn-datatable" type="button" data-toggle="modal" data-target="#Modaltambahtunjangan">
        <i class="fas fa-plus"></i>
    </button>
</template>

<script>
    function tambahtunjangan(event, id_pegawai) {
        var tbody = $(`#tunjangan-${id_pegawai}`)
        var tunjangan = 0
        var check = tbody.find('.checktunjangan').each(function (index, element) {
            var value = $(element).is(':checked')
            if (value == true) {
                var tr = $(element).parent().parent().parent()
                var td = $(tr).find('.jumlah_tunjangan')[0]
                var jumlah = $(td).html()
                var splitjumlah = jumlah.split('Rp')[1].replace('.', '').replace('.', '').replace(',00', '')
                    .trim()

                tunjangan = tunjangan + parseInt(splitjumlah)
            }
        })

        var nama_pegawai = $(`#nama_pegawai-${id_pegawai}`).html()
        var jabatan = $(`#jabatan-${id_pegawai}`).html()
        var gajipokok = $(`#gajipokok-${id_pegawai}`).html()

        var totalgaji = parseInt(gajipokok.split('Rp.')[1].replace('.', '').replace('.', '').replace(',00', '')
            .trim()) + tunjangan


        var table = $('#dataTableKonfirmasi').DataTable()
        var row = $(`#pegawai-${id_pegawai}`).parent().parent()
        table.row(row).remove().draw();

        var totalgajipokok = $('#total_gaji').val()
        var splitgajipokok = parseInt(gajipokok.split('Rp.')[1].replace('.', '').replace('.', '').replace(',00', '')
            .trim())
        var jumlahfix2 = splitgajipokok + parseInt(totalgajipokok)

        $('#total_gaji').val(jumlahfix2)

        var totaltunjangan = $('#total_tunjangan').val()
        var jumlahfix3 = tunjangan + parseInt(totaltunjangan)
        $('#total_tunjangan').val(jumlahfix3)

        // DATA PPH21 -----------------------------------------------------------------------------------------
        var datapph21 = $('#pph21').children()
        var children = $(datapph21).children()

        // 50JT
        var td1 = children[2]
        var pph1 = $($(td1)).html().split('Rp')[1].replace('.', '').replace('.', '').replace('.', '').replace(',00',
            '').trim()
        var tdpersen1= children[3]
        var pphpersen1 = $($(tdpersen1)).html()
        
        // 250JT
        var td2 = children[6]
        var pph2 = $($(td2)).html().split('Rp')[1].replace('.', '').replace('.', '').replace('.', '').replace(',00',
            '').trim()
        var tdpersen2 = children[7]
        var pphpersen2 = $($(tdpersen2)).html()
       
        // 500JT
        var td3 = children[10]
        var pph3 = $($(td3)).html().split('Rp')[1].replace('.', '').replace('.', '').replace('.', '').replace(',00',
            '').trim()
        var tdpersen3= children[11]
        var pphpersen3 = $($(tdpersen3)).html()
        
        // DIATAS 500JT
        var tdpersen4= children[15]
        var pphpersen4 = $($(tdpersen4)).html()

        // PERHITUNGAN DENGAN PPH21 dan PTKP ---------------------------------------------------------------
        var besaranptkp = $(`#besaran_ptkp-${id_pegawai}`).html().split('Rp')[1].replace('.', '').replace('.', '').replace('.', '').replace(',00',
            '').trim()
        console.log(besaranptkp)
        var gajitahunan = totalgaji * 12
        var gajikenapajak = gajitahunan - besaranptkp
        console.log(gajitahunan, gajikenapajak)
        

        if (gajikenapajak <= pph1){
            var pphlevel1 = gajikenapajak * pphpersen1
            var pphlevel1fix = pphlevel1 / 100
            // FIX PPH Level 2
            var pphlevel1bulan = pphlevel1fix / 12

            if(pphlevel1bulan < 0){

                var totaltambahtunjangan = $('#gaji_diterima').val()
                var jumlahfix3 = totalgaji + parseInt(totaltambahtunjangan)
                $('#gaji_diterima').val(jumlahfix3)

                alert('Berhasil Menambahkan Gaji Pegawai, Pegawai tidak dikenakan Pajak')

                $('#dataTableKonfirmasi').DataTable().row.add([
                nama_pegawai, `<span id=pegawai-${id_pegawai}>${nama_pegawai}</span>`, jabatan, gajipokok,
                new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(tunjangan),
                new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(totalgaji),
                new Intl.NumberFormat('id', {
                        style: 'currency',
                        currency: 'IDR'
                        }).format(0),
                ]).draw();

            }else{

                // Total gaji - PPH perbulan dan Penambahan pada Grand Total
                var totaltambahtunjangan = $('#gaji_diterima').val()
                var totalgajisangatfix = totalgaji - pphlevel1bulan
                var jumlahfix3 = totalgajisangatfix + parseInt(totaltambahtunjangan)
                $('#gaji_diterima').val(jumlahfix3)
                alert('Berhasil Menambahkan Pegawai dan Tunjangan')

                $('#dataTableKonfirmasi').DataTable().row.add([
                    nama_pegawai, `<span id=pegawai-${id_pegawai}>${nama_pegawai}</span>`, jabatan, gajipokok,
                    new Intl.NumberFormat('id', {
                        style: 'currency',
                        currency: 'IDR'
                        }).format(tunjangan),
                    new Intl.NumberFormat('id', {
                        style: 'currency',
                        currency: 'IDR'
                        }).format(totalgajisangatfix),
                    new Intl.NumberFormat('id', {
                        style: 'currency',
                        currency: 'IDR'
                        }).format(pphlevel1bulan),
                ]).draw();


                var totalpph21 = $('#total_pph21').val()
                var jumlahpph21fix = parseInt(pphlevel1bulan) + parseInt(totalpph21)
                $('#total_pph21').val(jumlahpph21fix)

               
            }

            
        }else if (gajikenapajak > pph1 && gajikenapajak <= pph2){

            // Perhitungan 5%
            var pphkena5 = pph1
            var pphkena5fix = pphkena5 * pphpersen1
            var pphkena5sangat = pphkena5fix / 100
           
            // Perhitungan 15%
            var pphkena15 = gajikenapajak - pph1
            var pphkena15fix = pphkena15 * pphpersen2
            var pphkena15sangat = pphkena15fix / 100

            // Penambahan
            var pphlevel2 = pphkena5sangat + pphkena15sangat
            var pphlevel2hampir = pphlevel2 / 12
            // Memecah Bilangan Decimal
            var str=pphlevel2hampir.toString();
            var numarray=str.split('.');    
            var a=new Array();
            a=numarray;

            // FIX PPH Level 2
            var pphlevel2bulan = a[0];

            // Total gaji - PPH perbulan dan Penambahan pada Grand Total
            var totaltambahtunjangan = $('#gaji_diterima').val()
            var totalgajisangatfix1 = totalgaji - pphlevel2bulan
            var jumlahfix3 = totalgajisangatfix1 + parseInt(totaltambahtunjangan)
            $('#gaji_diterima').val(jumlahfix3)


            alert('Berhasil Menambahkan Gaji Pegawai')
            

            $('#dataTableKonfirmasi').DataTable().row.add([
                nama_pegawai, `<span id=pegawai-${id_pegawai}>${nama_pegawai}</span>`, jabatan, gajipokok,
                new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(tunjangan),
                new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(totalgajisangatfix1),
                new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(pphlevel2bulan),
            ]).draw();

            var totalpph21 = $('#total_pph21').val()
            var jumlahpph21fix = parseInt(pphlevel2bulan) + parseInt(totalpph21)
            $('#total_pph21').val(jumlahpph21fix)
           
        }else if (gajikenapajak > pph2 && gajikenapajak <= pph3){
            
            // Perhitungan 5%
            var pph3kena5 = pph1
            var pph3kena5fix = pph3kena5 * pphpersen1
            var pph3kena5sangat = pph3kena5fix / 100
           

            // Perhitungan 15 %
            var pph3kena15 = pph2
            var pph3kena15fix = pph3kena15 * pphpersen2
            var pph3kena15sangat = pph3kena15fix / 100
        

            // Perhitungan 25%
            var pph3kena25 = parseInt(pph3kena15) + parseInt(pph3kena5)
            var tespph3kena25 = parseInt(gajikenapajak - pph3kena25)
            var pph3kena25fix = tespph3kena25 * pphpersen3
            var pph3kena25sangat = pph3kena25fix / 100
            

            var pphlevel3 = parseInt(pph3kena5sangat + pph3kena15sangat + pph3kena25sangat)
            var pphlevel3hampir = pphlevel3 / 12

            var str=pphlevel3hampir.toString();
            var numarray=str.split('.');    
            var a=new Array();
            a=numarray;

            // FIX PPH Level 2
            var pphlevel3bulan = a[0];

             // Total gaji - PPH perbulan dan Penambahan pada Grand Total
             var totaltambahtunjangan = $('#gaji_diterima').val()
             var totalgajisangatfix2 = totalgaji - pphlevel3bulan
             var jumlahfix3 = totalgajisangatfix2 + parseInt(totaltambahtunjangan)
             $('#gaji_diterima').val(jumlahfix3)

             alert('Berhasil Menambahkan Gaji Pegawai')
            
            $('#dataTableKonfirmasi').DataTable().row.add([
                nama_pegawai, `<span id=pegawai-${id_pegawai}>${nama_pegawai}</span>`, jabatan, gajipokok,
                new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(tunjangan),
                new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(totalgajisangatfix2),
                new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(pphlevel3bulan),
            ]).draw();

            var totalpph21 = $('#total_pph21').val()
            var jumlahpph21fix = parseInt(pphlevel3bulan) + parseInt(totalpph21)
            $('#total_pph21').val(jumlahpph21fix)
            
        }
    }


    function tambahgaji(event, tunjangan, id_gaji_pegawai) {
        event.preventDefault()
        var form1 = $('#form1')
        var tahun_gaji = form1.find('input[name="tahun_gaji"]').val()
        var bulan_gaji = $('#bulan_gaji').val()
        var id_jenis_transaksi = $('#id_jenis_transaksi').val()
        var grand_total_gaji = $('#gaji_diterima').val()
        var grand_total_tunjangan = $('#total_tunjangan').val()
        var grand_total_pph21 = $('#total_pph21').val()
        var id_bengkel = $('#id_bengkel').text()
        var keterangan = form1.find('textarea[name="keterangan"]').val()
        var _token = form1.find('input[name="_token"]').val()
        var pegawai = []
        var tunjangan = []

        var datapegawai = $('#konfirmasi').children()
        for (let index = 0; index < datapegawai.length; index++) {
            var children = $(datapegawai[index]).children()
            var td = children[1]
            var span = $(td).children()[0]

            var id_pegawai = $(span).attr('id')
            var id = id_pegawai.split('pegawai-')[1]
            var tes1 = $($(td).parent().children())
            var total_tunjangan = $($(td).parent().children()[4]).html().split('Rp')[1].replace('&nbsp;', '')
                .replace(
                    '.', '').replace('.', '').replace(',00', '').trim()
            var total_gaji = $($(td).parent().children()[5]).html().split('Rp')[1].replace('&nbsp;', '').replace(
                '.',
                '').replace('.', '').replace(',00', '').trim()
            var total_pph21 = $($(td).parent().children()[6]).html().split('Rp')[1].replace('&nbsp;', '').replace(
                '.',
                '').replace('.', '').replace(',00', '').trim()

            pegawai.push({
                id_pegawai: id,
                id_bengkel: id_bengkel,
                total_tunjangan: total_tunjangan,
                total_gaji: total_gaji,
                total_pph21: total_pph21
            })

            var tbody = $(`#tunjangan-${id}`)
            var check = tbody.find('.checktunjangan').each(function (index, element) {
                var value = $(element).is(':checked')
                if (value == true) {
                    var tr = $(element).parent().parent().parent()
                    var id_tunjangan = $(tr).attr('id').split('item-')[1]

                    tunjangan.push({
                        id_pegawai: id,
                        id_tunjangan: id_tunjangan,
                        id_bengkel: id_bengkel
                    })

                }

            })
        }

        if ( tahun_gaji == '' | bulan_gaji == '') {
            var alert = $('#alertdatakosong').show()
        } else {
            var data = {
                _token: _token,
                tahun_gaji: tahun_gaji,
                bulan_gaji: bulan_gaji,
                grand_total_gaji: grand_total_gaji,
                grand_total_tunjangan: grand_total_tunjangan,
                grand_total_pph21: grand_total_pph21,
                keterangan: keterangan,
                pegawai: pegawai,
                tunjangan: tunjangan
                // tunjangan: dataform2
            }


            $.ajax({
                method: 'put',
                url: '/payroll/gaji-pegawai/' + id_gaji_pegawai,
                data: data,
                success: function (response) {
                    window.location.href = '/payroll/gaji-pegawai'

                },
                error: function (response) {
                    console.log(response)
                }
            });
        }
    }


    function editgaji(element) {
        var table = $('#dataTablekonfirmasi').DataTable()
        // Akses Parent Sampai <tr></tr>
        var row = $(element).parent().parent()
        var children = $(row).children()[1]
        var kode = $($(children).children()[0]).attr('id')
        var id = kode.split('pegawai-')[1]
        $(`#${id}-button`).trigger('click');


    }


    function hapusgaji(element) {
        var table = $('#dataTableKonfirmasi').DataTable()

        // Akses Parent Sampai <tr></tr>
        var row = $(element).parent().parent()
        table.row(row).remove().draw();
        alert('Data Tunjangan Berhasil di Hapus')
        // draw() Reset Ulang Table
        var table = $('#dataTable').DataTable()
        var table2 = $('#dataTabletunjangankonfirmasi').DataTable()

        // Akses Parent Sampai <tr></tr>
        var row2 = $(element).parent().parent()

        // Pengurangan Total Gaji Pokok
        var totalgajipokok = $('#total_gaji').val()
        var gajipokok = $(row2.children()[3]).html()
        var splitgajipokok = parseInt(totalgajipokok) - parseInt(gajipokok.split('Rp.')[1].replace('.', '').replace(
            '.',
            '').replace(',00', '').trim())
        $('#total_gaji').val(splitgajipokok)

        // Pengurangan Tunjangan
        var totaltunjangan = $('#total_tunjangan').val()
        var tunjangan = $(row2.children()[4]).html()
        var splittunjangan = parseInt(totaltunjangan) - parseInt(tunjangan.split('Rp')[1].replace('&nbsp;', '')
            .replace(
                '.', '').replace(',00', '').trim())

        $('#total_tunjangan').val(splittunjangan)

        var totalpph21 = $('#total_pph21').val()
        var pph21 = $(row2.children()[6]).html()
        var pph21fix = pph21.split('Rp')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(',00', '').trim()
        var splitpph = parseInt(totalpph21) - parseInt(pph21fix)
            console.log(totalpph21, pph21, pph21fix, splitpph)
        $('#total_pph21').val(splitpph)

        // Pengurangan Grand Total Keseluruhan
        var grandtotal = $('#gaji_diterima').val()
        var grand = $(row2.children()[5]).html()
        var splitgrand = parseInt(grandtotal) - parseInt(grand.split('Rp')[1].replace('&nbsp;', '').replace('.', '')
            .replace('.', '').replace(',00', '').trim())

        $('#gaji_diterima').val(splitgrand)
    }

    $(document).ready(function () {

        $('#besaran_gaji').on('input', function () {
            var nominal = $(this).val()
            var nominal_fix = new Intl.NumberFormat('id', {
                style: 'currency',
                currency: 'IDR'
            }).format(nominal)

            $('#detailbesarangaji').html(nominal_fix);
        })

        var table_pegawai = $('#dataTablePegawai').DataTable({
            "pageLength": 5,
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, ]
            ]
        })

        var table2 = $('#dataTableAbsensi').DataTable()
        // var table = $('#dataTablesemuatunjangan').DataTable()
        var template = $('#template_delete_button').html()
        $('#dataTableKonfirmasi').DataTable({
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": template
                },
                {
                    "targets": 0,
                    "data": null,
                    'render': function (data, type, row, meta) {
                        return meta.row + 1
                    }
                }
            ]
        });
    });

</script>

@endsection
