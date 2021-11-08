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
                            <div class="page-header-icon" style="color: white"><i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <div class="page-header-subtitle" style="color: white">Edit Data Pembayaran Pajak</div>
                        </h1>
                        <div class="small">
                            <span class="font-weight-500">Pajak</span>
                            · Tambah · Data
                        </div>
                    </div>
                    <div class="col-12 col-xl-auto">
                        <a href="{{ route('pajak.index') }}" class="btn btn-sm btn-light text-primary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="alert alert-danger" id="alertpajakkosong" role="alert" style="display:none"> <i
                    class="fas fa-times"></i>
                Error! Terdapat Data Kosong!
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
                    <div class="card card-header-actions">
                        <div class="card-header ">Formulir Pajak
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pajak.store') }}" id="form1" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="kode_pajak">Kode Pajak</label>
                                    <input class="form-control" id="kode_pajak" type="text" name="kode_pajak"
                                        placeholder="Input Kode Pajak" value="{{ $pajak->kode_pajak }}" readonly />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="status_jurnal">Status Jurnal</label>
                                    <input class="form-control" id="status_jurnal" type="text" name="status_jurnal"
                                        value="Pending" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="id_pegawai">Pegawai</label>
                                <input class="form-control" id="id_pegawai" type="text" name="id_pegawai"
                                    placeholder="Input Kode Receiving" value="{{ Auth::user()->pegawai->nama_pegawai }}"
                                    readonly />
                            </div>
                            <div class="form-group">
                                <label class="small mb-1 mr-1" for="id_jenis_transaksi">Jenis
                                    Transaksi</label><span class="mr-4 mb-3" style="color: red">*</span>
                                    <input class="form-control" id="id_jenis_transaksi" type="text" name="id_jenis_transaksi"
                                    placeholder="Input Kode Receiving" value=" {{ $pajak->Jenistransaksi->nama_transaksi }}"
                                    readonly />
                            </div>

                            <div class="form-group">
                                <label class="small mb-1" for="tanggal_bayar">Tanggal Pembayaran</label>
                                <input class="form-control" id="tanggal_bayar" type="date" name="tanggal_bayar"
                                    placeholder="Input Tanggal Receive" value="<?php echo date('Y-m-d'); ?>"
                                    class="form-control @error('tanggal_bayar') is-invalid @enderror" />
                                @error('tanggal_bayar')<div class="text-danger small mb-1">{{ $message }}
                                </div> @enderror
                            </div>
                            <div class="form-group">
                                <label class="small mb-1 mr-1" for="deskripsi_pajak">Deskripsi</label> <span class="mr-4 mb-3"
                                style="color: red">*</span>
                                <textarea class="form-control" id="deskripsi_pajak" type="text" name="deskripsi_pajak"
                                    placeholder="Deskripsi Pembayaran"
                                    class="form-control @error('deskripsi_pajak') is-invalid @enderror">{{ $pajak->deskripsi_pajak }}</textarea>
                                @error('deskripsi_pajak')<div class="text-danger small mb-1">{{ $message }}
                                </div> @enderror
                            </div>
                            <div class="form-group text-right">
                                <hr>
                                <a href="{{ route('pajak.index') }}" class="btn btn-sm btn-light">Kembali</a>
                                <button class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                                    data-target="#Modalsumbit">Simpan</button>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card card-header-actions">
                        <div class="card-header">
                            Detail Pajak
                            @if ($pajak->status_pajak == 'Tidak Terkait')
                            <a href="" class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                                data-target="#Modaltambahpajak">
                                Tambah Pajak
                            </a>
                            @else

                            @endif

                        </div>
                        <div class="card-body">
                            <div class="datatable">
                                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered table-hover dataTable"
                                                id="dataTablekonfirmasi" width="100%" cellspacing="0" role="grid"
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
                                                            style="width: 80px;">
                                                            Data Pajak</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Start date: activate to sort column ascending"
                                                            style="width: 150px;">
                                                            Keterangan Pajak</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Office: activate to sort column ascending"
                                                            style="width: 120px;">
                                                            Nilai Pajak</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Start date: activate to sort column ascending"
                                                            style="width: 30px;">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='konfirmasi'>
                                                    @forelse ($pajak->Detailpajak as $item)
                                                    <tr id="item-{{ $item->id_detail_pajak }}" role="row" class="odd">
                                                        {{-- <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th> --}}
                                                        <td></td>
                                                        <td class="kode_sparepartedit"><span id="{{ $item->id_detail_pajak }}">{{ $item->data_pajak }}</span></td>
                                                        <td class="nama_sparepartedit">{{ $item->keterangan_pajak }}</td>
                                                        <td class="total_hargaedit">Rp {{ number_format($item->nilai_pajak,2,',','.')}}</td>
                                                        <td>
                                                          
                                                        </td>
                                                    </tr>
                                                    @empty
                                                        
                                                    @endforelse
                                                </tbody>
                                                <tr id="grandtotal">
                                                    <td colspan="3" class="text-center font-weight-500">
                                                        Total Pajak
                                                    </td>
                                                    <td colspan="2" class="grand_total text-center font-weight-500">
                                                        <span>Rp. </span><span id="totalpajak">{{ $pajak->total_pajak ?? 0 }}</span>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    
</main>

<div class="modal fade" id="Modaltambahpajak" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Pajak</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" id="closetambahpajak"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="" method="POST" id="form2" class="d-inline">
                <div class="modal-body">
                    <div class="alert alert-info small" role="alert">
                        Isikan Form Terlebih Dahulu
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="data_pajak">Data Pajak</label>
                        <div class="input-group input-group-joined">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-clipboard-list"></i>
                                </span>
                            </div>
                            <input class="form-control" id="data_pajak" type="text" name="data_pajak"
                                placeholder="Input Data Pajak">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                                <label class="small mb-1" for="nilai_pajak">Nominal Pajak</label>
                            </div>
                            <div class="col-12 col-lg-auto text-center text-lg-right">
                                <div class="small text-lg-right">
                                    <span class="font-weight-500 text-primary">Detail Nominal: </span>
                                    <span id="detailnominalpajak"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group input-group-joined">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    Rp.
                                </span>
                            </div>
                            <input class="form-control" id="nilai_pajak" type="number" name="nilai_pajak"
                                placeholder="Input Nominal Pajak">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="keterangan_pajak">Keterangan Pajak</label>
                        <div class="input-group input-group-joined">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-align-left"></i>
                                </span>
                            </div>
                            <textarea class="form-control" id="keterangan_pajak" type="text" name="keterangan_pajak"
                                placeholder="Input Keterangan Pajak"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success btn-sm" onclick="tambahpajak(event)" type="button">Tambah Pajak</button>
                </div>
        </div>
        </form>
    </div>
</div>




<div class="modal fade" id="Modaltransaksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Jenis Transaksi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('jenis-transaksi.store') }}" method="POST" class="d-inline">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="small mb-1" for="nama_transaksi">Jenis Transaksi</label>
                        <textarea class="form-control" name="nama_transaksi" type="text" id="nama_transaksi"
                            placeholder="Input Jenis Transaksi" value="{{ old('nama_transaksi') }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">Ya! Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="Modalsumbit" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success-soft">
                <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Form Pembelian</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">Apakah Form yang Anda inputkan sudah benar?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" onclick="submit(event,{{ $pajak }}, {{ $id_pajak }})"
                    type="button">Ya Sudah!</button>
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
    function submit(event, pajak, id_pajak) {
        console.log(id_pajak)
        event.preventDefault()
        var form1 = $('#form1')
        var kode_pajak = form1.find('input[name="kode_pajak"]').val()
        var id_pegawai = $('#id_pegawai').val()
        var tanggal_bayar = form1.find('input[name="tanggal_bayar"]').val()
        var deskripsi_pajak = form1.find('textarea[name="deskripsi_pajak"]').val()
        var dataform2 = []
        var _token = form1.find('input[name="_token"]').val()
        var total_pajak = $('#totalpajak').html()

        var pajak = $('#konfirmasi').children()

        for (let index = 0; index < pajak.length; index++) {
            var children = $(pajak[index]).children()
            var td_datapajak = children[1]
            var datapajak = $(td_datapajak).html()

            if (datapajak == ''){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Anda Belum Memasukan Data Pajak',
                    timer: 2000,
                    timerProgressBar: true,
                })
            }else{
                var td_keterangan_pajak = children[2]
                var keteranganpajak = $(td_keterangan_pajak).html()

                var td_nilai_pajak = children[3]
                var nilaipajak = $(td_nilai_pajak).html()
                var nilaipajak_fix = nilaipajak.split('Rp')[1].replace('&nbsp;', '').replace('.', '').replace('.', '')
                    .replace(',00', '').trim()
            

                dataform2.push({
                    id_pajak: id_pajak,
                    data_pajak: datapajak,
                    keterangan_pajak: keteranganpajak,
                    nilai_pajak: nilaipajak_fix
                })
            }

           
        }


        if (dataform2.length == 0  | deskripsi_pajak == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Anda Belum Memasukan Data Pajak dan Deskripsi',
                timer: 2000,
                timerProgressBar: true,
            })
        } else {
            var sweet_loader =
                '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';

            var data = {
                _token: _token,
                kode_pajak: kode_pajak,
                id_pegawai: id_pegawai,
                tanggal_bayar: tanggal_bayar,
                deskripsi_pajak: deskripsi_pajak,
                total_pajak: total_pajak,
                pajak: dataform2
            }


            $.ajax({
                method: 'put',
                url: '/accounting/pajak/' + id_pajak,
                data: data,
                beforeSend: function () {
                    swal.fire({
                        title: 'Mohon Tunggu!',
                        html: 'Data Pajak Sedang Diproses...',
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
                    window.location.href = '/accounting/pajak'
                    console.log(response)
                },
                error: function (response) {
                    console.log(response)
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: '<h5>Error!</h5>'
                    });
                }
            });
        }
    }




    function tambahpajak(event) {
        var form = $('#form2')
        var _token = form.find('input[name="_token"]').val()
        var data_pajak = form.find('input[name="data_pajak"]').val()
        var nilai_pajak = form.find('input[name="nilai_pajak"]').val()
        var nilai_pajak_fix = new Intl.NumberFormat('id', {
            style: 'currency',
            currency: 'IDR'
        }).format(nilai_pajak)
        var keterangan_pajak = form.find('textarea[name="keterangan_pajak"]').val()


        if (nilai_pajak == 0 | nilai_pajak == '' | data_pajak == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terdapat Field Kosong!',
                timer: 2000,
                timerProgressBar: true,
            })
        } else {

            var totalpajak = $('#totalpajak').html()
            var totalpajakfix = parseInt(nilai_pajak) + parseInt(totalpajak)
            $('#totalpajak').html(totalpajakfix)


            $('#dataTablekonfirmasi').DataTable().row.add([
                data_pajak, data_pajak, keterangan_pajak, nilai_pajak_fix
            ]).draw();

            $('#closetambahpajak').click()

           

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
                title: 'Berhasil Menambah Data Pajak'
            })
        }
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
                var table = $('#dataTablekonfirmasi').DataTable()
                var row = $(element).parent().parent()
                table.row(row).remove().draw();

                var pajakberkurang = $(row.children()[3]).text()
                var splitpajak = pajakberkurang.split('Rp')[1].replace('.', '').replace('.', '').replace(',00', '').trim()

                var totalpajak = $('#totalpajak').html()
                var totalpajakfix = parseInt(totalpajak) - parseInt(splitpajak)
                $('#totalpajak').html(totalpajakfix)
            }
        })
     
    }

    $(document).ready(function () {
       


        $('#nilai_pajak').on('input', function () {
            var nominal = $(this).val()
            var nominal_fix = new Intl.NumberFormat('id', {
                style: 'currency',
                currency: 'IDR'
            }).format(nominal)

            $('#detailnominalpajak').html(nominal_fix);
        })

        $('#tanggal_bayar').on('change', function () {
            var select = $(this)
            var textdate = select.val()
            var splitdate = textdate.split('-')
            console.log(splitdate)
            var datefix = new Date(splitdate[0], splitdate[1] - 1, splitdate[2])
            var formatindodate = new Intl.DateTimeFormat('id', {
                dateStyle: 'long'
            }).format(datefix)
            $('#detailtanggalbayar').html(formatindodate);
        })

        var template = $('#template_delete_button').html()
        $('#dataTablekonfirmasi').DataTable({
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
