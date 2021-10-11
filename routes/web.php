<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['verify' => true]);


Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login')->name('login');

Route::get('/register', 'Auth\RegisterController@showRegisterForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::get("/getkabupaten/{id}", "Auth\RegisterController@kabupaten_baru");
Route::get("/getkecamatan/{id}", "Auth\RegisterController@kecamatan_baru");
Route::get("/getdesa/{id}", "Auth\RegisterController@desa_baru");


Route::get('account/password', 'Account\PasswordController@edit')->name('password.edit');
Route::patch('account/password', 'Account\PasswordController@update')->name('password.edit');

Route::group(
    ['middleware' => 'auth'],
    function () {
        // -------------------------------------------------------------------------------------------------------ACCOUNTING
        // MODUL ACCOUNTING
        // DASHBOARD
        Route::prefix('accounting')
            ->namespace('Accounting')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::get('/', 'DashboardaccountingController@index')
                    ->name('dashboardaccounting');
            });

        // MASTER DATA ---------------------------------------------------- Master Data Accounting
        Route::prefix('accounting/masterdatafop')
            ->namespace('Accounting\Masterdata')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::get('/', 'MasterdatafopController@index')
                    ->name('masterdatafop');

                Route::resource('fop', 'MasterdatafopController');
            });

        Route::prefix('accounting/masterdatabankaccount')
            ->namespace('Accounting\Masterdata')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::get('/', 'MasterdatabankaccountController@index')
                    ->name('masterdatabankaccount');

                Route::resource('bank-account', 'MasterdatabankaccountController');
            });

        Route::prefix('accounting/masterdataakun')
            ->namespace('Accounting\Masterdata')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::get('/', 'MasterdataakunController@index')
                    ->name('masterdataakun');

                Route::resource('akun', 'MasterdataakunController');
            });

        Route::prefix('accounting')
            ->namespace('Accounting\Masterdata')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::resource('jenis-transaksi', 'MasterdatajenistransaksiController');
            });

        Route::prefix('accounting')
            ->namespace('Accounting\Masterdata')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::resource('penentuan-akun', 'PenentuanAkunController');
            });

        // PAYABLE ---------------------------------------------------------------------------------------------- PAYABLE
        // InvoicePayable ----------------------------------------------------------------- Invoice Payable   
        Route::prefix('Accounting')
            ->namespace('Accounting\Payable')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::resource('invoice-payable', 'InvoicePayableController');
                Route::get('cetak-invoice/{id}', 'InvoicePayableController@CetakInvoice')->name('cetak-invoice');
            });

        // PRF ---------------------------------------------------------------------------- PRF
        Route::prefix('accounting')
            ->namespace('Accounting\Payable')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::resource('prf', 'PrfController');

                Route::post('Prf/{id_prf}', 'PrfController@statusBayar')
                    ->name('prf-bayar');
                Route::get('/prf/{id_prf}/edit2', 'PrfController@edit2')
                    ->name('prf-edit');
                Route::get('cetak-prf/{id}', 'PrfController@Cetakprf')->name('cetak-prf');
            });

        // Approval Prf ----------------------------------------------------------------- Approval PRF
        Route::prefix('accounting/ApprovalPRF')
            ->namespace('Accounting\Payable')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::get('/', 'ApprovalprfController@index')
                    ->name('approval-prf');

                Route::resource('approval-prf', 'ApprovalprfController');

                Route::post('Prf/{id_prf}/set-status', 'ApprovalprfController@setStatus')
                    ->name('approval-prf-status');
            });

        // PAJAK -------------------------------------------------------------------------- Pajak
        Route::prefix('accounting')
            ->namespace('Accounting\Payable')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {

                Route::resource('pajak', 'PajakController');
                Route::put('/pajak/pegawai/{id}', 'PajakController@pajakpegawai')
                    ->name('pajak-pegawai');
                Route::get('/pajak/{id}/edit', 'PajakController@editpajak')
                    ->name('pajak-edit');
                Route::get('cetak-pajak/{id}', 'PajakController@CetakPajak')->name('cetak-pajak');
            });

        // Gaji Pegawai Accounting ----------------------------------------------------------------- Gaji Pegawai Accounting  
        Route::prefix('Accounting')
            ->namespace('Accounting\Payable')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::resource('gaji-accounting', 'GajiAccountingController');

                Route::put('gaji-accounting/posting-jurnal/{id}', 'GajiAccountingController@postingjurnal')
                    ->name('gaji-pegawai-jurnal');
                Route::post('gaji-pegawai/{id_gaji_pegawai}/status-dana', 'GajiAccountingController@setStatusPerBulanTahun')
                    ->name('gaji-pegawai-status-dana');
            });

        Route::prefix('Accounting')
            ->namespace('Accounting\Receiveable')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::resource('pemasukan-kasir', 'PemasukanController');
                Route::get('pemasukan-online/{tanggal_transaksi}', 'PemasukanController@Pemasukanonline')
                    ->name('pemasukan-online');
                Route::get('pemasukan-service/{tanggal_laporan}', 'PemasukanController@Laporanservice')
                    ->name('pemasukan-service');
            });


        // Jurnal Pengeluaran ----------------------------------------------------------------- Jurnal Pengeluaran 
        Route::prefix('Accounting')
            ->namespace('Accounting\Jurnal')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::resource('jurnal-pengeluaran', 'JurnalPengeluaranController');

                Route::post('Pajak/{id_pajak}', 'JurnalPengeluaranController@Pajak')
                    ->name('jurnal-pengeluaran-pajak');
                Route::post('PPH21/{id_pajak}', 'JurnalPengeluaranController@PPH21')
                    ->name('jurnal-pengeluaran-pph21');
                Route::post('PRF/{id_prf}', 'JurnalPengeluaranController@Prf')
                    ->name('jurnal-pengeluaran-prf');
            });

        Route::prefix('Accounting')
            ->namespace('Accounting\Jurnal')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::resource('jurnal-penerimaan', 'JurnalPenerimaanController');
            });


        Route::prefix('Accounting')
            ->namespace('Accounting\Laporan')
            ->middleware(['admin_accounting_gabung', 'verified'])
            ->group(function () {
                Route::resource('laporan-laba-rugi', 'LaporanLabaRugiController');
                Route::get('cetak-laporan-laba-rugi/{id}', 'LaporanLabaRugiController@CetakLaporan')
                    ->name('cetak-laporan-laba-rugi');
            });
    }
);
