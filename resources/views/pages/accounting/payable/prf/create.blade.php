@extends('layouts.Admin.adminaccounting')

@section('content')
{{-- HEADER --}}
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon" style="color: white"><i
                                    class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div class="page-header-subtitle mr-2" style="color: white">Tambah Data Payment Requisition
                                Form
                            </div>
                        </h1>
                        <div class="small">
                            <span class="font-weight-500">PRF</span>
                            · Tambah · Data
                            <span class="font-weight-500 text-primary" id="id_bengkel" style="display:none">{{ Auth::user()->bengkel->id_bengkel}}</span>
                        </div>
                    </div>
                    <div class="col-12 col-xl-auto">
                        <a href="{{ route('prf.index') }}" class="btn btn-sm btn-light text-primary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="container mt-n10">
        <div class="row">
            <div class="col-lg-3">
                <div class="card mb-4">
                    <div class="card card-header-actions">
                        <div class="card-header ">Form PRF
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('prf.store') }}" id="form1" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="small mb-1" for="kode_prf">Kode PRF</label>
                                <input class="form-control" id="kode_prf" type="text" name="kode_prf"
                                    placeholder="Input Kode Invoice" value="{{ $prf->kode_prf }}" readonly />
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="id_jenis_transaksi">Jenis Transaksi</label>
                                <input class="form-control" id="id_jenis_transaksi" type="text" name="id_jenis_transaksi"
                                    placeholder="Input Kode Invoice" value="{{ $prf->Jenistransaksi->nama_transaksi }}" readonly />
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="tanggal_prf">Tanggal Pembuatan PRF</label><span
                                    class="mr-4 mb-3" style="color: red">*</span>
                                <input class="form-control" id="tanggal_prf" type="date" name="tanggal_prf"
                                    placeholder="Input Tanggal Prf" value="<?php echo date('Y-m-d'); ?>"
                                    class="form-control @error('tanggal_prf') is-invalid @enderror" />
                                @error('tanggal_prf')<div class="text-danger small mb-1">{{ $message }}
                                </div> @enderror
                                {{-- <div class="small" id="alerttanggal" style="display:none">
                                    <span class="font-weight-500 text-danger">Error! Tanggal Belum Terisi!</span>
                                    <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div> --}}
                                <div class="small" id="alerttanggal" style="display:none">
                                    <span class="font-weight-500 text-danger">Error! Tanggal Belum Terisi!</span>
                                    <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="small mb-1" for="keperluan_prf">Deskripsi Keperluan</label><span
                                    class="mr-4 mb-3" style="color: red">*</span>
                                <textarea class="form-control" id="keperluan_prf" type="text" name="keperluan_prf"
                                    placeholder="Input Keperluan PRF" value="{{ old('keperluan_prf') }}"
                                    class="form-control @error('keperluan_prf') is-invalid @enderror"> </textarea>
                                @error('keperluan_prf')<div class="text-danger small mb-1">{{ $message }}
                                </div> @enderror
                                <div class="small" id="alertdeskripsi" style="display:none">
                                    <span class="font-weight-500 text-danger">Error! Deskripsi Belum Terisi!</span>
                                    <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="card">
                    <div class="card card-header-actions">
                        <div class="card-header ">Detail Invoice Supplier
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="datatable">
                            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-hover dataTable" id="dataTableDetail"
                                            width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                            style="width: 100%;">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending"
                                                        style="width: 20px;">No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 100px;">Kode Invoice</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 60px;">Kode PO</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 50px;">Tanggal Invoice</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 50px;">Tenggat Invoice</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 100px;">Total Biaya</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 50px;">Kode Rcv</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 50px;">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($prf->Supplier->InvoicePayable as $item)
                                                <tr id="invoice-{{ $item->id_payable_invoice }}" role="row" class="odd">
                                                    <th scope="row" class="small" class="sorting_1">
                                                        {{ $loop->iteration}}</th>
                                                    <td class="kode_invoice">{{ $item->kode_invoice }}</td>
                                                    <td class="kode_po">{{ $item->PO->kode_po }}</td>
                                                    <td class="tanggal_invoice">{{ $item->tanggal_invoice }}</td>
                                                    <td class="tenggat_invoice">{{ $item->tenggat_invoice }}</td>
                                                    <td class="total_pembayaran">
                                                        Rp.{{ number_format($item->total_pembayaran,2,',','.') }}</td>
                                                    <td class="kode_rcv">{{ $item->Rcv->kode_rcv }}</td>
                                                    <td>
                                                        <a href="" class="btn btn-primary btn-datatable" type="button"
                                                            data-toggle="modal"
                                                            data-target="#Modalinvoice-{{ $item->id_payable_invoice }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button class="btn btn-success btn-datatable"
                                                            onclick="tambahinvoice(event, {{ $item->id_payable_invoice }})"
                                                            type="button" data-dismiss="modal"><i
                                                                class="fas fa-plus"></i>
                                                        </button>
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
        </div>
    </div>

    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card card-header-actions">
                        <div class="card-header ">Konfirmasi
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger" id="alertinvoicekosong" role="alert" style="display:none"> <i
                            class="fas fa-times"></i>
                        Error! Anda belum menambahkan Invoice Supplier!
                        <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                        <div class="datatable">
                            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-hover dataTable"
                                            id="dataTableKonfirmasi" width="100%" cellspacing="0" role="grid"
                                            aria-describedby="dataTable_info" style="width: 100%;">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending"
                                                        style="width: 20px;">No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 100px;">Kode Invoice</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 60px;">Kode Rcv</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 100px;">Total Biaya</th>
                                                    <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 50px;">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody id="konfirmasi">
                                                
                                            </tbody>
                                           
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-header">Detail Pembayaran
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="id_supplier">Supplier</label>
                                <input class="form-control" id="id_supplier" type="text" name="id_supplier"
                                    placeholder="Input Kode Invoice" value="{{ $prf->Supplier->nama_supplier }}"
                                    readonly />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="no_rek">No Rekening Supplier</label>
                                <input class="form-control" id="no_rek" type="text" name="no_rek"
                                    placeholder="Input Kode Invoice" value="{{ $prf->Supplier->rekening_supplier }}"
                                    readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="id_fop">Pilih Metode Pembayaran</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <div class="input-group input-group-joined">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-money-bill-wave-alt"></i>
                                    </span>
                                </div>
                                <select class="form-control" name="id_fop" id="id_fop">
                                    <option>Pilih Metode Pembayaran</option>
                                    @foreach ($fop as $fops)
                                    <option value="{{ $fops->id_fop }}">{{ $fops->nama_fop }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="small" id="alertpembayaran" style="display:none">
                                <span class="font-weight-500 text-danger">Error! Metode Pembayaran Belum Di Pilih!</span>
                                <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        </div>
                       
                        <div class="row" id="bank" style="display:none">
                            <div class="form-group col-md-6">
                                <label class="small mb-1 mr-1" for="id_akun_bank">Pilih Bank</label><span
                                    class="mr-4 mb-3" style="color: red">*</span>
                                <div class="input-group input-group-joined">
                                    <input class="form-control" type="text" placeholder="Pilih Bank" aria-label="Search"
                                        id="detailbank">
                                    <div class="input-group-append">
                                        <a href="" class="input-group-text" type="button" data-toggle="modal"
                                            data-target="#ModalBank">
                                            <i class="fas fa-folder-open"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="nomor_rekening">Nomor Rekening</label>
                                <input class="form-control" id="detailrekening" type="text" name="nomor_rekening"
                                    readonly />
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <hr>
                            <a href="{{ route('prf.index') }}" class="btn btn-sm btn-light">Kembali</a>
                            <button class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                                data-target="#Modalsumbit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
</main>

{{-- Modal Bank --}}
<div class="modal fade" id="ModalBank" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-header bg-light ">
                <h5 class="modal-title">Pilih Bank</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="datatable">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTableBank"
                                    width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                    style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 20px;">No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 50px;">Kode Bank</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 90px;">Nama Bank</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                                style="width: 150px;">Nama Account</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 70px;">Jenis Account</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 120px;">No. Rekening</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Actions: activate to sort column ascending"
                                                style="width: 60px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($akun_bank as $bank)
                                        <tr id="bank-{{ $bank->id_bank_account }}" role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td class="kode_bank" id="kode_bank_tes">{{ $bank->kode_bank }}</td>
                                            <td class="nama_bank">{{ $bank->Bank->nama_bank }}</td>
                                            <td class="nama_account">{{ $bank->nama_account }}</td>
                                            <td class="jenis_account">{{ $bank->jenis_account }}</td>
                                            <td class="nomor_rekening">{{ $bank->nomor_rekening }}</td>
                                            <td>
                                                <button class="btn btn-success btn-xs"
                                                    onclick="tambahbank(event, {{ $bank->id_bank_account }})"
                                                    type="button" data-dismiss="modal">Tambah
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="tex-center">
                                                Data Bank Kosong
                                            </td>
                                        </tr>
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

{{-- MODAL DETAIL INVOICE --}}
@forelse ($prf->Supplier->InvoicePayable as $item)
<div class="modal fade" id="Modalinvoice-{{ $item->id_payable_invoice }}" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Detail Item Invoice</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="datatable">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTableDetailInvoice"
                                    width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                    style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 20px;">No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 60px;">Kode Rcv</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 150px;">Nama Sparepart</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Jenis</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Merk</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 30px;">Qty Rcv</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Harga Sparepart</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($item->Detailinvoice as $invoice)
                                        <tr id="sparepart-{{ $item->id_sparepart }}" role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">
                                                {{ $loop->iteration}}</th>
                                            <td class="kode_sparepart">{{ $invoice->kode_sparepart }}</td>
                                            <td class="nama_sparepart">{{ $invoice->nama_sparepart }}</td>
                                            <td class="jenis_sparepart">
                                                {{ $invoice->Merksparepart->Jenissparepart->jenis_sparepart }}
                                            </td>
                                            <td class="merk_sparepart">
                                                {{ $invoice->Merksparepart->merk_sparepart }}
                                            </td>
                                            <td class="qty_rcv">{{ $invoice->pivot->qty_rcv }}
                                            </td>
                                            <td class="harga_diterima">Rp.{{ number_format($invoice->pivot->harga_item,2,',','.') }}
                                            </td>
                                            <td class="total_harga">Rp.{{ number_format($invoice->pivot->total_harga,2,',','.') }}
                                            </td>


                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                    <tr>
                                        <td colspan="7" class="text-center font-weight-500">
                                            Total Harga
                                        </td>
                                        <td>Rp.{{ number_format($item->total_pembayaran,2,',','.') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@empty

@endforelse




{{-- MODAL SUBMIT --}}
<div class="modal fade" id="Modalsumbit" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success-soft">
                <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Invoice</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">Apakah Form Invoice yang Anda inputkan sudah benar?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" data-dismiss="modal"
                    onclick="tambahprf(event,{{ $prf->Supplier->InvoicePayable  }},{{ $prf->id_prf }})">Ya Sudah!</button>
            </div>
        </div>
    </div>
</div>



<template id="template_delete_button">
    <button class="btn btn-danger btn-datatable" onclick="hapussparepart(this)" type="button">
        <i class="fas fa-trash"></i>
    </button>
</template>

<template id="template_add_button">
    <button class="btn btn-success btn-datatable" type="button" data-toggle="modal" data-target="#Modaltambah">
        <i class="fas fa-plus"></i>
    </button>
</template>


<script>
    function tambahprf(event, invoice, id_prf) {
        event.preventDefault()
        var form1 = $('#form1')
        var id_jenis_transaksi = $('#id_jenis_transaksi').val()
        var tanggal_prf = form1.find('input[name="tanggal_prf"]').val()
        var keperluan_prf = form1.find('textarea[name="keperluan_prf"]').val()
        var id_fop = $('#id_fop').val()
        var nama_bank = $('#detailbank').val()
        var kode_bank = $('#kode_bank_tes').html()
        var dataform2 = []
        var _token = form1.find('input[name="_token"]').val()

        var datainvoice = $('#konfirmasi').children()
        for (let index = 0; index < datainvoice.length; index++) {
            var children = $(datainvoice[index]).children()
            var td = children[1]
            var span = $(td).children()[0]
            var id = $(span).attr('id')

            if (id == undefined | id == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Anda Belum Memilih Invoice',
                })
            } else {

                var tdharga = children[6]
                var harga_satuan_tes= $(tdharga).html()
                var harga_invoice = harga_satuan_tes.replace('Rp.', '').
                    .replace('.', '').replace('.', '').replace(',00', '').trim()

                var obj = {
                        id_payable_invoice: id,
                        harga_invoice: harga_invoice
                    }
                dataform2.push(obj)
            }
        }

        if (dataform2.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Anda Belum Memilih Invoice',
                timer: 2000,
                timerProgressBar: true,
            })
        } else if (tanggal_prf == '' | tanggal_prf == 0 |keperluan_prf == '' | keperluan_prf == 0 | keperluan_prf == 'NULL'){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Anda Belum Mengisi Keperluan PRF',
                timer: 2000,
                timerProgressBar: true,
            })
        } else if (id_fop == 'Pilih Metode Pembayaran'){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Anda Belum Mengisi Metode Pembayaran',
                timer: 2000,
                timerProgressBar: true,
            })
        } else {
            var sweet_loader =
                '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';
                

            var data = {
                _token: _token,
                id_jenis_transaksi: id_jenis_transaksi,
                tanggal_prf: tanggal_prf,
                keperluan_prf: keperluan_prf,
                id_fop: id_fop,
                kode_bank: kode_bank,
                invoice: dataform2
            }
            $.ajax({
                method: 'put',
                url: '/accounting/prf/' + id_prf,
                data: data,
                beforeSend: function () {
                    swal.fire({
                        title: 'Mohon Tunggu!',
                        html: 'Data PRF Sedang Diproses...',
                        showConfirmButton: false,
                        onRender: function () {
                            // there will only ever be one sweet alert open.
                            $('.swal2-content').prepend(sweet_loader);
                        }
                    });
                },
                success: function (response) {
                    swal.fire({
                        icon: 'success',
                        showConfirmButton: false,
                        html: '<h5>Success!</h5>'
                    });
                    window.location.href = '/accounting/prf'

                },
                error: function (response) {
                    consolle.log(response)
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: '<h5>Error!</h5>'
                    });
                }
            });
        }
    }



    function tambahbank(event, id_bank_account) {
        var data = $('#bank-' + id_bank_account)
        var _token = $(data.find('input[name="_token"]')[0]).val()
        var nama_bank = $(data.find('.nama_bank')[0]).text()
        var nomor_rekening = $(data.find('.nomor_rekening')[0]).text()

        $('#detailbank').val(nama_bank)
        $('#detailrekening').val(nomor_rekening)

        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Berhasil Menambah Account Bank'
            })

    }

    function tambahinvoice(event, id_payable_invoice) {
        var data = $('#invoice-' + id_payable_invoice)
        var kode_invoice = $(data.find('.kode_invoice')[0]).text()
        var kode_rcv = $(data.find('.kode_rcv')[0]).text()
        var total_pembayaran = $(data.find('.total_pembayaran')[0]).text()
        var template = $($('#template_delete_button').html())

        var table = $('#dataTableKonfirmasi').DataTable()
        var row = $(`#${$.escapeSelector(kode_invoice.trim())}`).parent().parent()
        table.row(row).remove().draw();

        $('#dataTableKonfirmasi').DataTable().row.add([
            kode_invoice, `<span id=${kode_invoice}>${kode_invoice}</span>`, `<span id=${id_payable_invoice}>${kode_rcv}</span>`, total_pembayaran,
            kode_invoice
        ]).draw();

        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Berhasil Menambah Data Invoice' + kode_invoice
            })

    }


    function hapussparepart(element) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var table = $('#dataTableKonfirmasi').DataTable()

                // Akses Parent Sampai <tr></tr>
                var row = $(element).parent().parent()
                table.row(row).remove().draw();
              
                var table = $('#dataTable').DataTable()

                // Akses Parent Sampai <tr></tr>
                var row2 = $(element).parent().parent()
            }
        })
        
    }

    $(document).ready(function () {
        $('#id_fop').on('change', function () {
            var select = $(this).find('option:selected')
            var akun = select.text().trim()
            if (akun == 'Transfer') {
                $('#bank').show();
            } else {
                $('#bank').hide();
            }
        })

        var tablercv = $('#dataTableRcv').DataTable()

        var tabledetail = $('#dataTableDetail').DataTable({
            "pageLength": 5,
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, ]
            ]
        })

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


        var tablebank = $('#dataTableBank').DataTable({
            "pageLength": 5,
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, ]
            ]
        })
        // var tabledetailinvoice = $('#dataTableDetailInvoice').DataTable()

    });

</script>


@endsection
