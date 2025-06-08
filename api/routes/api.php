<?php

use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Article\ArticleImageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Doctor\DoctorEducationController;
use App\Http\Controllers\Doctor\DoctorExperienceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Doctor\DoctorProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaveArticleController;
use App\Http\Controllers\SaveDoctorController;
use App\Http\Controllers\MedicalRecord\MedicalRecordController;
use App\Models\DoctorProfile;
use App\Models\User;
use PhpParser\Comment\Doc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Broadcast;

use App\Events\MessageSent;
use App\Http\Controllers\PusherAuthController;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:register');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/verify-reset-code', [AuthController::class, 'verifyResetCode']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'getMe']);
    });
});

Route::get('/file/{filename}', function ($filename) {
    $path = "bookings/{$filename}";

    if (!Storage::exists($path)) {
        return response()->json(['error' => 'File not found'], 404);
    }

    return Storage::download($path);
})->name('file.download');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/getSetting', [DoctorProfileController::class, 'getSetting']);
});

Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::put('/info', [UserController::class, 'info']);
    Route::post('/avatar', [UserController::class, 'updateAvatar']);
    Route::delete('/avatar', [UserController::class, 'deleteAvatar']);
    Route::put('/update-password', [UserController::class, 'updatePassword']);

});

Route::middleware('auth:sanctum')->prefix('contacts')->group(function () {
    Route::get('/', [ContactController::class, 'index']);
    Route::get('/{id}', [ContactController::class, 'find']);
    Route::post('/', [ContactController::class, 'store']);
    // Route::delete('/{id}', [ContactController::class, 'destroy']);
    Route::delete('/', [ContactController::class, 'massDestroy']);
});


Route::prefix('calendars')->group(function () {
    // doctor
    Route::get('/', [BookingController::class, 'getCalendar'])->middleware('auth:sanctum');
    // admin
    Route::get('/admin', [BookingController::class, 'getBookingCalendar'])->middleware('auth:sanctum');
});
Route::prefix('bookings')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [BookingController::class, 'store']);
        Route::get('/', [BookingController::class, 'index']);
        Route::put('/check-doctor', [BookingController::class, 'checkDoctor']); // admin
        Route::put('/assign-doctor', [BookingController::class, 'assignDoctor']); // admin

        Route::get('/count-services', [BookingController::class, 'countTypeService']); // User
        Route::get('/count-booking', [BookingController::class, 'countTypeBooking']); // User

        Route::get('/count-metting', [BookingController::class, 'countTotalBookingToday']); // doctor
        Route::get('/count-info', [BookingController::class, 'countTotalInformation']); // doctor
        Route::get('/chart-data', [BookingController::class, 'doctorChartData']); // doctor
        Route::get('/countTotalInformationWebsite', [BookingController::class, 'countTotalInformationWebsite']);
        Route::put('/{id}', [BookingController::class, 'update']);
        Route::put('/checkAvailability/{id}', [BookingController::class, 'checkAvailability']);
        Route::delete('/{id}', [BookingController::class, 'destroy']);
        Route::get('/{id}', [BookingController::class, 'find']);
        Route::get('/doctor-booking/{id}', [BookingController::class, 'doctorBooking']);
        // admin
        Route::put('/status/{id}', [BookingController::class, 'updateBookingStatus']);
        // user cancel
        Route::put('/statuscancel/{id}', [BookingController::class, 'cancelBooking']);
        Route::put('/remove/{id}', [BookingController::class, 'removeBooking']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-medical/{id}', [MedicalRecordController::class, 'getUserMedicalRecord']);
    Route::get('/medical-records', [MedicalRecordController::class, 'index']);
    Route::post('/medical-records', [MedicalRecordController::class, 'store']);
    Route::get('/medical-records/{id}', [MedicalRecordController::class, 'find']);
    Route::put('/medical-records/{id}', [MedicalRecordController::class, 'update']);
    Route::delete('/medical-records/{id}', [MedicalRecordController::class, 'destroy']);

    Route::put('/medical-record/complete/{id}', [BookingController::class, 'completeBooking']);
    Route::get('/getMedicalRecord', [MedicalRecordController::class, 'getMedicalRecord']);
    Route::get('/invoice/{id}/downloads', [MedicalRecordController::class, 'downloadInvoice']);
    Route::get('/medical-record/{id}/downloads', [MedicalRecordController::class, 'downloadMedicalRecord']);
});

Route::prefix('chat')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/whoami', [ConversationController::class, 'getSenderId']);
        Route::get('/conversations', [ConversationController::class, 'index']);
        Route::post('/conversations', [ConversationController::class, 'createConversation']);
        Route::post('/find-conversation', [ConversationController::class, 'findOrCreate']);
        Route::get('/messages/{conversation_id}', [MessageController::class, 'getMessages']);
        Route::post('/messages', [MessageController::class, 'sendMessage']);
    });
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });
});

Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [TagController::class, 'store']);
        Route::post('/{id}', [TagController::class, 'update']);
        Route::delete('/{id}', [TagController::class, 'destroy']);
    });
});

// notification
Route::prefix('notifications')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::put('/{id}/read', [NotificationController::class, 'markAsRead']);
    });
});

Route::prefix('specialists')->group(function () {
    Route::get('/', [SpecialistController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [SpecialistController::class, 'store']);
        Route::put('/{id}', [SpecialistController::class, 'update']);
        Route::delete('/{id}', [SpecialistController::class, 'destroy']);
    });
});

Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::get('/{id}', [DepartmentController::class, 'show']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [DepartmentController::class, 'store']);
        Route::put('/{id}', [DepartmentController::class, 'update']);
        Route::delete('/{id}', [DepartmentController::class, 'destroy']);
    });
});

Route::get('/centers', [CenterController::class, 'index']);


Route::delete('/mass-delete-article', [ArticleController::class, 'massDestroy'])->middleware('auth:sanctum');
Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('/{id}', [ArticleController::class, 'find']);
    Route::post('/view/{id}', [ArticleController::class, 'incrementViewCount']);

    Route::post('/upload-image/{id}', [ArticleImageController::class, 'uploadImage']);
    Route::delete('/delete-image/{id}', [ArticleImageController::class, 'deleteImage']);

    Route::middleware('auth:sanctum')->group(function () {
        // Route::get('/author', [ArticleController::class, 'getAuthor']);
        Route::post('/', [ArticleController::class, 'store']);
        Route::post('/{id}', [ArticleController::class, 'update']);
        Route::delete('/{id}', [ArticleController::class, 'destroy']);
        Route::post('/{article}/save', [ArticleController::class, 'save']);
        Route::delete('/{article}/save', [ArticleController::class, 'unsave']);
        Route::get('/saved-articles', [ArticleController::class, 'savedArticles']);
    });
});

Route::prefix('author')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [ArticleController::class, 'getAuthor']);
        Route::get('/write-article', [ArticleController::class, 'checkAuthor']);
        Route::get('/article-count', [ArticleController::class, 'countArticle']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'userProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/categories', [CategoryController::class, 'store']);
});


Route::prefix('services')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [ServiceController::class, 'store']);
        // Route::post('/{id}', [ServiceController::class, 'update']);
        Route::post('/sub/{id}', [ServiceController::class, 'updateSub']);
        Route::post('/main/{id}', [ServiceController::class, 'updateMain']);
        Route::delete('/{id}', [ServiceController::class, 'destroy']);
    });
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/{id}', [ServiceController::class, 'find']);
});

// Route::middleware('auth:sanctum')->prefix('saves')->group(function () {
//     Route::get('/', [SaveController::class, 'index']);
//     Route::get('/{id}', [SaveController::class, 'find']);
//     Route::post('/', [SaveController::class, 'store']);
//     Route::delete('/{id}', [SaveController::class, 'destroy']);
// });

Route::prefix('doctor')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/biography', [DoctorProfileController::class, 'getBiography']);
        Route::put('/biography', [DoctorProfileController::class, 'updateBiography']);

        Route::prefix('admin')->group(function () {
            Route::post('/', [AuthController::class, 'registerDoc']);
            Route::post('/{id}', [DoctorProfileController::class, 'updateProfile']);
        });
    });

    Route::prefix('profiles')->group(function () {
        Route::get('/', [DoctorProfileController::class, 'index']);
        Route::get('/{id}', [DoctorProfileController::class, 'find']);
    });

});



Route::prefix('doctor')->middleware('auth:sanctum')->group(function () {
    Route::prefix('educations')->group(function () {
        Route::get('/', [DoctorEducationController::class, 'index']);
        Route::get('/{id}', [DoctorEducationController::class, 'find']);
        Route::post('/', [DoctorEducationController::class, 'store']);
        Route::put('/{id}', [DoctorEducationController::class, 'update']);
        Route::delete('/{id}', [DoctorEducationController::class, 'destroy']);
    });

    Route::prefix('experiences')->group(function () {
        Route::get('/', [DoctorExperienceController::class, 'index']);
        Route::get('/{id}', [DoctorExperienceController::class, 'find']);
        Route::post('/', [DoctorExperienceController::class, 'store']);
        Route::put('/{id}', [DoctorExperienceController::class, 'update']);
        Route::delete('/{id}', [DoctorExperienceController::class, 'destroy']);
    });

    Route::prefix('profiles')->group(function () {
        Route::post('/', [DoctorProfileController::class, 'store']);
        Route::put('/{id}', [DoctorProfileController::class, 'update']);
        Route::delete('/{id}', [DoctorProfileController::class, 'destroy']);
    });
});



Route::prefix('save')->middleware('auth:sanctum')->group(function () {
    Route::prefix('articles')->group(function () {
        Route::get('/', [SaveArticleController::class, 'index']);
        Route::post('/', [SaveArticleController::class, 'store']);
        Route::delete('/{id}', [SaveArticleController::class, 'destroy']);
    });

    Route::prefix('doctors')->group(function () {
        Route::get('/', [SaveDoctorController::class, 'index']);
        Route::post('/', [SaveDoctorController::class, 'store']);
        Route::delete('/{id}', [SaveDoctorController::class, 'destroy']);
    });
});

