<?php

// use App\Http\Controllers\AuthorController;
// use App\Http\Controllers\BookController;
// use App\Http\Controllers\ReviewController;
// use App\Http\Controllers\UserController;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use Laravel\Sanctum\Sanctum;
// use App\Http\Middleware\RoleMiddleware;
// use App\Models\Review;

// Route::get('/register', [UserController::class, 'create'])->name('register');
// Route::post('register', [UserController::class, 'store']);

// Route::get('/login', [UserController::class, 'loginForm'])->name('login');
// Route::post('/login', [UserController::class, 'login']);

// Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify-otp');
// Route::get('/resend-otp', [UserController::class, 'sendOtp'])->name('resend-otp');


// route::get('profile', [UserController::class, 'index']);
// Route::middleware('auth')->group(function () {
//     Route::get('/home', function () {
//         return view('book.index');
//     })->name('home');
//     Route::get('show_books', [BookController::class, 'index'])->name('books.index');

//     Route::post('/logout', [UserController::class, 'logout'])->name('logout');
//     Route::post('/borrow', [BookController::class, 'borrow'])->name('borrow');
//     Route::post('/return', [BookController::class, 'return'])->name('return');
//     route::get('profile', [UserController::class, 'index']);
//     route::post('rating', [ReviewController::class, 'store'])->name('rating');
//     Route::middleware('role:Administrator')->group(function () {

//         Route::post('add_books', [BookController::class, 'store'])->name('add_books');
//         Route::put('edit_book/{book}', [BookController::class, 'update'])->name('dit_book');
//         Route::delete('delete_book/{book}', [BookController::class, 'destroy'])->name('delete_book');
//         route::post('add_author', [AuthorController::class, 'store'])->name('add_author');
//         Route::put('edit_author/{author}', [AuthorController::class, 'update'])->name('edit_author');
//         Route::delete('delete_author/{author}', [AuthorController::class, 'destroy'])->name('delete_author');
//     });
// }); -->
