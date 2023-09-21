<?php


use App\Http\Controllers\Admin\TwoFactorAuthenticationController;
use App\Http\Controllers\web\ClassroomController;
use App\Http\Controllers\web\ClassroomPeopleController;
use App\Http\Controllers\web\ClassworkController;
use App\Http\Controllers\web\CommentController;
use App\Http\Controllers\web\JoinClassroomController;
use App\Http\Controllers\web\PaymentsController;
use App\Http\Controllers\web\PlansController;
use App\Http\Controllers\web\PostController;
use App\Http\Controllers\web\ProfileController;
use App\Http\Controllers\web\SubmissionController;
use App\Http\Controllers\web\SubscriptionsController;
use App\Http\Controllers\web\TopicController;
use App\Http\Controllers\Webhooks\StripeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/', function () {
    return view('auth.login');
})->name('home');

Route::get('plans', [PlansController::class, 'index'])->name('plans');
Route::get('admin/2fa', [TwoFactorAuthenticationController::class, 'create']);
Route::post('/payments/stripe/webhook', StripeController::class);

Route::middleware(['auth'])->group(callback: function () {

    //subscriptions
    Route::post('subscriptions', [SubscriptionsController::class, 'store'])->name('subscriptions.store');
    Route::get('subscriptions/{subscription}/pay', [PaymentsController::class, 'create'])->name('checkout');

    //payments
    Route::post('payments', [PaymentsController::class, 'store'])->name('payments.store');
    Route::get('payments/{subscription}/success', [PaymentsController::class, 'success'])->name('payments.success');
    Route::get('payments/{subscription}/cancel', [PaymentsController::class, 'cancel'])->name('payments.cancel');

    //posts
    Route::post('classrooms/{classroom}/posts', [PostController::class, 'store'])
        ->name('posts.store');

    //Join classroom
    Route::get('classroom/{classroom}/join', [JoinClassroomController::class, 'create'])->middleware('signed')->name('classroom.join');
    Route::post('classroom/{classroom}/join', [JoinClassroomController::class, 'store'])->name('classroom.join.store');

    //chat classroom
    Route::post('classroom/{classroom}/chat', [ClassroomController::class, 'chat'])->name('classrooms.chat');

// Route for archived classrooms
    Route::post('/classrooms/archive/{classroom}', [ClassroomController::class, 'archive'])->name('classrooms.archive');
    Route::get('/classrooms/archived', [ClassroomController::class, 'archived'])->name('classrooms.archived');
    Route::post('/classrooms/restore/{classroom}', [ClassroomController::class, 'restore'])->name('classrooms.restore');

// Route for trashed classrooms
    Route::get('/classrooms/trashed', [ClassroomController::class, 'trashed'])->name('classrooms.trashed');

    Route::resources([
        'classrooms' => ClassRoomController::class,
        'classrooms.topics' => TopicController::class,
        'classrooms.classworks' => ClassworkController::class,
    ]);

//Route::get('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'index'])->name('classrooms.people');
//because has one invoke method
    Route::get('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'index'])->name('classrooms.people');
    Route::delete('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'destroy'])->name('classrooms.people.destroy');

    //comments
    Route::post('comment', [CommentController::class, 'store'])->name('comment.store');

    //submissions
    Route::post('classworks/{classwork}/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::post('classworks/{classwork}/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('submissions/{submission}/file', [SubmissionController::class, 'file'])->name('submissions.file');

    //notifications
    Route::get('notifications', [NotificationsController::class, 'index'])->name('notifications');

});



