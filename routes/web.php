<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\CinemaHallController;
use App\Http\Controllers\Admin\ShowtimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingManagementController;
use App\Http\Controllers\UserProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ====================================================================
// PUBLIC ROUTES (Bisa diakses oleh siapa saja, tanpa perlu login)
// ====================================================================

// Halaman Beranda / Daftar Film
Route::get('/', [HomeController::class, 'movieList'])->name('home');
Route::get('/movies', [HomeController::class, 'movieList'])->name('movies.list');

// Halaman Detail Film
Route::get('/movies/{movie}', [HomeController::class, 'showMovieDetail'])->name('movies.show');


// ====================================================================
// GUEST ROUTES (Hanya bisa diakses oleh pengguna yang BELUM login)
// ====================================================================
Route::middleware('guest')->group(function () {
    // Registrasi Pengguna
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    // Login Pengguna
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});


// ====================================================================
// AUTHENTICATED ROUTES (Hanya bisa diakses oleh pengguna yang SUDAH login)
// ====================================================================
Route::middleware('auth')->group(function () {
    // Logout Pengguna
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard Pengguna
    Route::get('/dashboard', [HomeController::class, 'userDashboard'])->name('user.dashboard');

    // Rute Pemesanan Tiket
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/select-seats/{showtime}', [BookingController::class, 'selectSeats'])->name('select_seats');
        Route::post('/process/{showtime}', [BookingController::class, 'processBooking'])->name('process');
        Route::get('/confirmation/{booking}', [BookingController::class, 'showConfirmation'])->name('confirmation');
        
        // ✅ Tambahan agar tidak error saat redirect setelah booking
        Route::get('/payment/{booking}', [BookingController::class, 'showPaymentForm'])->name('payment_form');
        Route::post('/payment/{booking}', [BookingController::class, 'processPayment'])->name('process_payment');

        Route::get('/my-bookings', [BookingController::class, 'userBookings'])->name('user_bookings');
    });

    // Manajemen Profil Pengguna
    Route::prefix('profile')->name('user.profile.')->group(function () {
        Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
        Route::put('/', [UserProfileController::class, 'update'])->name('update');
    });

    // ===============================================================
    // ADMIN ROUTES (Hanya bisa diakses oleh pengguna dengan role 'admin')
    // ===============================================================
    Route::middleware('admin')->group(function () {
        // Dashboard Admin
        Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');

        // Manajemen Film
        Route::prefix('admin/movies')->name('admin.movies.')->group(function () {
            Route::get('/', [MovieController::class, 'index'])->name('index');
            Route::get('/create', [MovieController::class, 'create'])->name('create');
            Route::post('/', [MovieController::class, 'store'])->name('store');
            Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('edit');
            Route::put('/{movie}', [MovieController::class, 'update'])->name('update');
            Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Studio/Hall Bioskop
        Route::prefix('admin/cinema-halls')->name('admin.cinema_halls.')->group(function () {
            Route::get('/', [CinemaHallController::class, 'index'])->name('index');
            Route::get('/create', [CinemaHallController::class, 'create'])->name('create');
            Route::post('/', [CinemaHallController::class, 'store'])->name('store');
            Route::get('/{hall}/edit', [CinemaHallController::class, 'edit'])->name('edit');
            Route::put('/{hall}', [CinemaHallController::class, 'update'])->name('update');
            Route::delete('/{hall}', [CinemaHallController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Jadwal Tayang
        Route::prefix('admin/showtimes')->name('admin.showtimes.')->group(function () {
            Route::get('/', [ShowtimeController::class, 'index'])->name('index');
            Route::get('/create', [ShowtimeController::class, 'create'])->name('create');
            Route::post('/', [ShowtimeController::class, 'store'])->name('store');
            Route::get('/{showtime}/edit', [ShowtimeController::class, 'edit'])->name('edit');
            Route::put('/{showtime}', [ShowtimeController::class, 'update'])->name('update');
            Route::delete('/{showtime}', [ShowtimeController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Pemesanan
        Route::prefix('admin/bookings')->name('admin.bookings.')->group(function () {
            Route::get('/', [BookingManagementController::class, 'index'])->name('index');
            Route::get('/{booking}', [BookingManagementController::class, 'show'])->name('show');
            Route::get('/{booking}/edit', [BookingManagementController::class, 'edit'])->name('edit');
            Route::put('/{booking}', [BookingManagementController::class, 'update'])->name('update');
            Route::delete('/{booking}', [BookingManagementController::class, 'destroy'])->name('destroy');
        });
    });
});