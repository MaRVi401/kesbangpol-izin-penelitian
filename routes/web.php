<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Mahasiswa\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevTemplateController;
use App\Http\Controllers\Operator\TicketController as OperatorTicketController;
use App\Http\Controllers\Admin\SiemController;
use App\Http\Controllers\Kabid\UsulanKabidController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FileController;
// use App\Http\Controllers\Mahasiswa\ServiceSubDomainController;
// use App\Http\Controllers\Mahasiswa\ServiceAppsCreationController;
// use App\Http\Controllers\Mahasiswa\ServiceComplaintSystemController;
use App\Http\Controllers\Mahasiswa\DetailSuratIzinPermohonan;
use App\Http\Controllers\Mahasiswa\ServiceHistoryTicketController;
// use App\Http\Controllers\Mahasiswa\ServiceEmailGovController;

/*
|--------------------------------------------------------------------------
| Test Error Routes
|--------------------------------------------------------------------------
*/

Route::get('/error/{code}', function ($code) {
    abort($code);
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Guest Routes (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Halaman Register
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    // Proses Register
    Route::post('/register', [RegisterController::class, 'register']);

    // Halaman Login
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    // Proses Login
    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.post');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Sudah Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard All Roles
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Rute untuk akses file di storage private
    Route::get('/storage/private/{path}', [FileController::class, 'show'])
    ->where('path', '.*')
    ->middleware('auth');

        // Edit profile

// Route untuk halaman profil
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

/**
 * Route khusus untuk menampilkan avatar dari storage private
 * Menggunakan parameter {filename} untuk mencari file di storage/app/avatars/
 */
Route::get('/user/avatar/{filename}', function ($filename) {
    $path = 'avatars/' . $filename;

    // Pastikan file ada di storage/app/avatars
    if (!Storage::disk('local')->exists($path)) {
        abort(404);
    }

    // Mengembalikan file sebagai response gambar
    return Storage::disk('local')->response($path);
})->name('avatar.display')->middleware('auth');

    // Proses Logout
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    /*
    |----------------------------------------------------------------------
    | Khusus Super Admin
    |----------------------------------------------------------------------
    */
    Route::middleware('can:super-admin-only')->group(function () {

        Route::get('user-management/pending-mahasiswa', [UserManagementController::class, 'pendingMahasiswa'])
            ->name('user-management.pending');
        Route::post('user-management/activate/{uuid}', [UserManagementController::class, 'activate'])
            ->name('user-management.activate');
        //User management
        Route::resource('user-management', UserManagementController::class)
            ->names('user-management')
            ->parameters(['user-management' => 'user']);

        Route::prefix('super-admin/siem')->name('siem.')->controller(SiemController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/security-logs', 'securityLogs')->name('security-logs');
            Route::get('/audit-trails', 'auditTrails')->name('audit-trails');
        });

    });

    /*
    |----------------------------------------------------------------------
    | Khusus Operator
    |----------------------------------------------------------------------
    */
    Route::middleware('can:operator-only')->group(function () {

        // Halaman Meja Kerja
        Route::get('workdesk', [OperatorTicketController::class, 'workDesk'])->name('ticket.workdesk');

        Route::prefix('dev')->group(function () {
            Route::get('/upload-template', [DevTemplateController::class, 'index'])->name('dev.template.index');
            Route::post('/upload-template', [DevTemplateController::class, 'store'])->name('dev.template.store');
        });

        // Proses Ambil Tiket
        Route::post('ticket/{uuid}/handle', [OperatorTicketController::class, 'handle'])->name('ticket.handle');

        // Proses Selesaikan Tiket
        Route::resource('ticket', OperatorTicketController::class)
            ->parameters(['ticket' => 'uuid'])
            ->only(['index', 'show', 'update', 'destroy']);

        Route::get('riwayat-tiket', [OperatorTicketController::class, 'history'])->name('ticket.history');
    });

    /*
    |----------------------------------------------------------------------
    | Khusus mahasiswa
    |----------------------------------------------------------------------
    */

    Route::middleware('can:mahasiswa-only')->group(function () {

        Route::resource('services', ServiceController::class);

        // // RUTE UNTUK DOWNLOAD Email Gov
        // Route::get('services/email-gov/download/{uuid}', [ServiceEmailGovController::class, 'download'])
        //     ->name('email.download');

        // // Rute baru untuk Email E-Gov
        // Route::resource('services-email-e-gov', ServiceEmailGovController::class);

        // //Rute baru untuk Sub Domain
        // Route::resource('service-sub-domain', ServiceSubDomainController::class);

        // //RUTE DOWNLOAD SUBDOMAIN
        // Route::get('services/subdomain/download/{uuid}', [ServiceSubDomainController::class, 'download'])
        //     ->name('subdomain.download');

        // //Rute baru untuk Pembuatan Apps
        // Route::get('/service-app-creation/download/{uuid}', [ServiceAppsCreationController::class, 'download'])->name('appscreation.download');
        // Route::resource('service-app-creation', ServiceAppsCreationController::class);

        // //Rute untuk pengaduan
        // Route::resource('service-complaint-system', ServiceComplaintSystemController::class);
        Route::resource('detail', DetailSuratIzinPermohonan::class);
        //Rute History Tiket
        Route::resource('history', ServiceHistoryTicketController::class);
        Route::post('services/autosave', [ServiceController::class, 'autosave'])
             ->middleware('throttle:30,1') // Maksimal 30 request per menit
             ->name('izin-penelitian.autosave');

        // //Rute Scanner Image
        // Route::view('/ai-scanner', 'pages.mahasiswa.layanan.test-scanner')->name('test.scanner');
    });

    /*
    |----------------------------------------------------------------------
    | Khusus Kabid
    |----------------------------------------------------------------------
    */
    Route::middleware('can:kabid-only')->group(function () {

        // Rute untuk fitur Usulan Prioritas Tiket
        Route::resource('usulan', UsulanKabidController::class)
            ->names('kabid.usulan')
            ->parameters(['usulan' => 'uuid'])
            ->only(['index', 'create', 'store', 'show', 'destroy']);
    });
});
