<?php

use App\Http\Controllers\GiveawayController;
use App\Http\Controllers\GiveawayParticipantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('giveaway', GiveawayController::class);
    Route::get('giveaway/{id}/participants', [GiveawayParticipantController::class, 'index'])->name('view.giveaway.participants');
    Route::get('giveaway/{giveaway}/participant/{giveawayParticipant}/make-winner', [GiveawayParticipantController::class, 'handleMakeWinner'])->name('giveaway.make-winner');
    Route::get('giveaway/{giveaway}/participants/round-robin', [GiveawayParticipantController::class, 'handleRoundRobinWinner'])->name('giveaway.round-robin-winner');

    Route::get('/send-money/{giveaway}', [GiveawayController::class, 'sendAmount'])->name('giveaway.send-money');
    Route::post('/send-money/{giveaway}', [GiveawayController::class, 'confirmUserhasSentAmountToAddress'])->name('giveaway.send-money-post');
});

// Route::get('claim-giveaway', function(){
//     return view('claim-giveaway');
// });


Route::get('claim-giveaway/{id}', [GiveawayParticipantController::class, 'create'])->name('claim-giveaway-participant');
Route::post('claim-giveaway/{id}', [GiveawayParticipantController::class, 'store'])->name('add-giveaway-participant');
require __DIR__.'/auth.php';
