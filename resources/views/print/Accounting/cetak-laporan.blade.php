<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cetak Laporan Laba Rugi {{ $laporan->kode_laporan }}</title>
    <link href="{{ url('backend/dist/css/styles.css')}}" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('image/favicon.png') }}">
    <link rel="stylesheet" href="{{ url('/node_modules/sweetalert2/dist/sweetalert2.min.css') }}">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="icon" type="image/x-icon" href={{ url('favicon.png')}} />

    <script data-search-pseudo-elements defer
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.27.0/feather.min.js" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ url('/node_modules/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
</head>

<body>
    <div>
        <main>
            <div class="container col-lg-8 mt-5">


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
                <div class="row align-items-center justify-content-between ml-15 mr-20">
                    <div class="col-7 col-xl-auto">
                        Pendapatan Jasa
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="pendapatan_jasa">Rp. {{ number_format($laporan->pendapatan_jasa,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-20">
                    <div class="col-7 col-xl-auto">
                        Pendapatan Penjualan On-Site
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="pendapatan_onsite">Rp.
                            {{ number_format($laporan->pendapatan_penjualan,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-20">
                    <div class="col-7 col-xl-auto">
                        Pendapatan Penjualan Online
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="pendapatan_online">Rp.
                            {{ number_format($laporan->pendapatan_penjualan_online,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-20">
                    <h6 class="col-7 col-xl-auto">
                        Total Pendapatan
                    </h6>
                    <h6 class="col-5 col-xl-auto">
                        <span id="total_pendapatan">Rp. {{ number_format($laporan->total_pendapatan,2,',','.') }}</span>
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
                <div class="row align-items-center justify-content-between ml-15 mr-20">
                    <div class="col-7 col-xl-auto">
                        Harga Pokok Penjualan
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="harga_pokok_penjualan">Rp.
                            {{ number_format($laporan->beban_harga_pokok_penjualan,2,',','.') }}</span>
                    </div>
                </div>
              

                {{-- TOTAL LABA KOTOR -----------------------------------------------------------------------------------------}}
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-20">
                    <h6 class="col-7 col-xl-auto">
                        Total Laba Kotor
                    </h6>
                    <h6 class="col-5 col-xl-auto">
                        <span id="total_laba_kotor">Rp. {{ number_format($laporan->total_laba_kotor,2,',','.') }}</span>
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
                <div class="row align-items-center justify-content-between ml-15 mr-20">
                    <div class="col-7 col-xl-auto">
                        Biaya Gaji Pegawai
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="beban_gaji">Rp. {{ number_format($laporan->beban_gaji,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-20">
                    <div class="col-7 col-xl-auto">
                        Biaya Pajak Penghasilan
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="beban_pajak_penghasilan">Rp.
                            {{ number_format($laporan->beban_pph21,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-20">
                    <div class="col-7 col-xl-auto">
                        Biaya Pajak
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="beban_pajak">Rp. {{ number_format($laporan->beban_pajak,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-20">
                    <h6 class="col-7 col-xl-auto">
                        Total Beban Operasional
                    </h6>
                    <h6 class="col-5 col-xl-auto">
                        <span id="total_beban">Rp. {{ number_format($laporan->total_beban,2,',','.') }}</span>
                    </h6>
                </div>

                {{-- LABA BERSIH OPERASIONAL --}}
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-20">
                    <h6 class="col-7 col-xl-auto">
                        Laba Bersih Operasional
                    </h6>
                    <h6 class="col-5 col-xl-auto">
                        <span id="laba_bersih_operasional">Rp.
                            {{ number_format($laporan->total_laba_bersih ,2,',','.') }}</span>
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
                <div class="row align-items-center justify-content-between ml-15 mr-20">
                    <div class="col-7 col-xl-auto">
                        Pendapatan Lainnya

                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="pendapatanlainnya">Rp.
                            {{ number_format($laporan->pendapatan_lainnya ,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-15 mr-20">
                    <div class="col-7 col-xl-auto">
                        Beban Lainnya
                    </div>
                    <div class="col-5 col-xl-auto">
                        <span id="bebanlainnya">Rp. {{ number_format($laporan->beban_lainnya ,2,',','.') }}</span>
                    </div>
                </div>
                <hr class="mr-10 ml-10">
                <div class="row align-items-center justify-content-between ml-10 mr-20">
                    @if ($laporan->status_laporan == 'Laba')
                    <h6 class="col-7 col-xl-auto text-primary">
                        TOTAL LABA BERSIH
                    </h6>
                    @else
                    <h6 class="col-7 col-xl-auto text-primary">
                        TOTAL RUGI
                    </h6>
                    @endif
                    <h6 class="col-5 col-xl-auto text-primary">
                        <span id="grand_total">Rp {{ number_format($laporan->grand_total ,2,',','.') }}</span>
                    </h6>
                </div>
              
                <div class="row align-items-center justify-content-between ml-10 mr-20">
                    <h6 class="col-7 col-xl-auto text-primary">
                    </h6>
                    <div class="col-5 col-xl-auto text-primary">
                        <div class="small text-muted">Status Laporan {{ $laporan->status_laporan }}</div>
                    </div>
                </div>
               
            </div>

            

            </a>

        </main>
    </div>
 
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ url('/backend/dist/js/scripts.js')}}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ url('/backend/dist/assets/demo/datatables-demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ url('/backend/dist/assets/demo/datatables-demo.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

</body>

</html>

<script type="text/javascript">
    window.print();

</script>
