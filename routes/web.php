<?php

use App\Http\Controllers\Applicant\Status\StatusBeasiswaController;
use App\Http\Controllers\Applicant\Status\StatusDaftarController;
use App\Http\Controllers\Applicant\Status\StatusRegistrasiController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Question\HomeController;
use App\Http\Controllers\Question\Scholarship\QuestionController;
use App\Http\Controllers\Question\Scholarship\ResultController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\Target\TargetDatabaseController;
use App\Http\Controllers\Target\TargetRevenueController;
use App\Http\Controllers\Target\TargetVolumeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Enrollment\EnrollmentController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Registration\RegistrationController;
use App\Http\Controllers\AchivementController;
use App\Http\Controllers\Applicant\Status\StatusApplicantController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ProgramTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicantStatusController;
use App\Http\Controllers\PresenterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserUploadController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\DataController;
use App\Http\Controlllers\API\ApplicantController as APIA;

use App\Http\Controllers\MailController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/link', function () {
    return view('link');
})->name('link');

Route::get('/events/{code}', [EventController::class, 'participant'])->name('events.index');
Route::post('/eventstore', [EventController::class, 'store_event'])->name('events.store_event');
Route::patch('/eventrating/{id}', [EventController::class, 'update_event'])->name('events.rating');

Route::prefix('recommendation-data')->group(function () {
    Route::get('/kkn', [DataController::class, 'kkn'])->name('recommendation-data.input-kkn');
    Route::post('/kkn', [DataController::class, 'kkn_store'])->name('recommendation-data.store-kkn');
});

/* Route Dashboard */
Route::middleware(['auth', 'status:1'])->group(function () {
    Route::resource('dashboard', DashboardController::class);

    Route::get('dashboard/rekapitulasi/perolehanpmb', [DashboardController::class, 'rekapitulasi_perolehan_pmb_page'])->name('dashboard.rekapitulasi_perolehan_pmb_page');

    Route::get('dashboard/page/history', [DashboardController::class, 'rekapitulasi_history'])->name('dashboard.rekapitulasi_history');
    Route::get('dashboard/page/rekapitulasi', [DashboardController::class, 'rekapitulasi_database'])->name('dashboard.rekapitulasi_database');
    Route::get('dashboard/page/perolehanpmb', [DashboardController::class, 'rekapitulasi_perolehan_pmb'])->name('dashboard.rekapitulasi_perolehan_pmb');
    Route::get('dashboard/page/register/program', [DashboardController::class, 'rekapitulasi_register_program'])->name('dashboard.rekapitulasi_register_program');
    Route::get('dashboard/page/aplikan', [DashboardController::class, 'rekapitulasi_aplikan'])->name('dashboard.rekapitulasi_aplikan');
    Route::get('dashboard/page/persyaratan', [DashboardController::class, 'rekapitulasi_persyaratan'])->name('dashboard.rekapitulasi_persyaratan');
    Route::get('dashboard/page/register/school', [DashboardController::class, 'rekapitulasi_register_school'])->name('dashboard.rekapitulasi_register_school');
    Route::get('dashboard/page/register/school/year', [DashboardController::class, 'rekapitulasi_register_school_year'])->name('dashboard.rekapitulasi_register_school_year');
    Route::get('dashboard/page/register/source', [DashboardController::class, 'rekapitulasi_register_source'])->name('dashboard.rekapitulasi_register_source');
    Route::get('dashboard/page/pencapaianpmb', [DashboardController::class, 'rekapitulasi_pencapaian_pmb'])->name('dashboard.rekapitulasi_pencapaian_pmb');

    Route::get('get/dashboard/all', [DashboardController::class, 'get_all'])->name('dashboard.get_all');
    Route::get('get/dashboard/sources/{pmb?}', [DashboardController::class, 'get_sources'])->name('dashboard.sourceget');
    Route::get('get/dashboard/sourcesdaftar/{pmb?}', [DashboardController::class, 'get_sources_daftar'])->name('dashboard.sourcedaftarget');
    Route::get('get/dashboard/presenters/{pmb?}', [DashboardController::class, 'get_presenters'])->name('dashboard.presenterget');
    Route::get('quicksearch/{name?}', [DashboardController::class, 'quick_search'])->name('quicksearch');
    Route::get('quicksearchstatus', [DashboardController::class, 'quick_search_status'])->name('quicksearchstatus');
    Route::get('quicksearchsource', [DashboardController::class, 'quick_search_source'])->name('quicksearchsource');
    Route::get('get/presenter', [DashboardController::class, 'get_presenter'])->name('dashboard.presenter');
});

/* Route School */
Route::middleware(['auth', 'status:1', 'role:A'])->group(function () {
    Route::resource('schools', SchoolController::class);
    // Route::get('get/schools', [SchoolController::class, 'get_all'])->name('schools.get');
    Route::post('import/schools', [SchoolController::class, 'import'])->name('school.import');
    Route::get('get/schools/setting', [SchoolController::class, 'setting'])->name('schools.setting');
    Route::post('migration/schools', [SchoolController::class, 'migration'])->name('school.migration');
    Route::post('clear/schools', [SchoolController::class, 'clear'])->name('school.clear');
    Route::post('clear/schools', [SchoolController::class, 'clear'])->name('school.clear');
    Route::post('makenull/schools/{id}', [SchoolController::class, 'make_null'])->name('school.makenull');
});

/* Route Database  */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('database', ApplicantController::class);
    /* Status Database */
    Route::patch('status/database/beasiswa/{id}', [StatusBeasiswaController::class, 'update'])->name('statusdatabasebeasiswa.update');

    Route::patch('status/database/aplikan/{id}', [StatusApplicantController::class, 'update'])->name('statusdatabaseaplikan.update');
    Route::delete('status/database/aplikan/{id}', [StatusApplicantController::class, 'destroy'])->name('statusdatabaseaplikan.destroy');

    Route::delete('status/database/daftar/{id}', [StatusDaftarController::class, 'destroy'])->name('statusdatabasedaftar.destroy');
    Route::delete('status/database/registrasi/{id}', [StatusRegistrasiController::class, 'destroy'])->name('statusdatabaseregistrasi.destroy');
    /* Import from Spreadsheet */
    Route::get('import/applicants/{start}/{end}/{macro}', [ApplicantController::class, 'import'])->name('applicant.import');
    Route::get('import/check-spreadsheet/{sheet}/{macro}', [ApplicantController::class, 'check_spreadsheet'])->name('applicant.check-spreadsheet');
    /* Export to Excel */
    Route::get('applicants/export/{dateStart?}/{dateEnd?}/{yearGrad?}/{schoolVal?}/{birthdayVal?}/{pmbVal?}/{sourceVal?}/{statusVal?}', [ApplicantController::class, 'export'])->name('applicants.export');
    /* Get data from Javascript in blade */
    Route::get('get/databases', [ApplicantController::class, 'get_all'])->name('database.get');
    Route::get('get/databasesbeasiswa', [ApplicantController::class, 'get_beasiswa'])->name('database.getbeasiswa');
    Route::get('isapplicant/{identity?}', [ApplicantController::class, 'is_applicant'])->name('database.is_applicant');
    Route::delete('isapplicant/{identity?}', [ApplicantController::class, 'delete_is_applicant'])->name('database.delete_is_applicant');
    Route::get('isschoolarship/{identity?}', [ApplicantController::class, 'is_schoolarship'])->name('database.is_schoolarship');
    Route::get('chat/{identity?}', [ApplicantController::class, 'chats'])->name('database.chat');
    Route::get('eventdetail/{identity?}', [ApplicantController::class, 'events'])->name('database.events');
    Route::get('file/{identity?}', [ApplicantController::class, 'files'])->name('database.file');
    Route::get('achievement/{identity?}', [ApplicantController::class, 'achievements'])->name('database.achievement');
    Route::get('organization/{identity?}', [ApplicantController::class, 'organizations'])->name('database.organization');
    Route::get('scholarship/{identity?}', [ApplicantController::class, 'scholarships'])->name('database.scholarship');
    Route::get('print/database/{id}', [ApplicantController::class, 'print'])->name('database.print');
});

/* Route Presenter  */
Route::middleware(['auth', 'status:1', 'role:A'])->group(function () {
    Route::resource('presenters', PresenterController::class);
    Route::get('get/presenters', [PresenterController::class, 'get_all'])->name('presenters.get');
});

/* Route Presenter  */
Route::middleware(['auth', 'status:1', 'role:A'])->group(function () {
    Route::resource('user', UserController::class)->middleware(['auth', 'role:A']);
    Route::get('get/users/{role?}/{status?}', [UserController::class, 'get_all'])->name('user.get');
    Route::patch('user/update_account/{id}', [UserController::class, 'update_account'])->name('user.update_account');
    Route::patch('user/change_password/{id}', [UserController::class, 'change_password'])->name('user.change_password');
    Route::get('user/reset_password_default/{id}', [UserController::class, 'reset_password_default'])->name('user.reset_password_default');
    Route::get('user/status/{id}', [UserController::class, 'status'])->name('user.status');
    Route::get('presenter/status/{id}', [PresenterController::class, 'status'])->name('presenters.status');
    Route::patch('presenter/change_password/{id}', [PresenterController::class, 'change_password'])->name('presenters.password');
    Route::get('presenter/sales/volume/{id}', [PresenterController::class, 'sales_volume'])->name('presenters.sales_volume');
    Route::get('presenter/sales/revenue/{id}', [PresenterController::class, 'sales_revenue'])->name('presenters.sales_revenue');
    Route::get('presenter/sales/database/{id}', [PresenterController::class, 'sales_database'])->name('presenters.sales_database');
});

/* Route Profile */
Route::middleware(['auth', 'status:1'])->group(function () {
    Route::resource('profile', ProfileController::class);
    Route::patch('profile/update_account/{id}', [ProfileController::class, 'update_account'])->name('profile.update_account');
    Route::patch('profile/change_password/{id}', [ProfileController::class, 'change_password'])->name('profile.change_password');
});

/* Route Student */
Route::middleware(['auth', 'status:1'])->group(function () {
    Route::resource('userupload', UserUploadController::class)->except(['store']);
    Route::resource('recommendation', RecommendationController::class);
    Route::patch('recommendation/admin/{id}', [RecommendationController::class, 'update_admin'])->name('recommendation.update_admin');
    Route::patch('recommendation/change/{id}', [RecommendationController::class, 'change_status'])->name('recommendation.change');
    Route::post('payment', [UserUploadController::class, 'upload_pembayaran'])->name('upload.payment');
});

/* Route Enrollment */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('enrollment', EnrollmentController::class);
    Route::get('get/enrollments', [EnrollmentController::class, 'get_all'])->name('enrollment.get');
    Route::patch('approve/enrollment/{id}', [EnrollmentController::class, 'approve'])->name('enrollment.approve');
});

/* Route Registration */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('registration', RegistrationController::class);
    Route::get('get/registrations', [RegistrationController::class, 'get_all'])->name('registration.get');
});

/* Route Integration */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('integration', IntegrationController::class);
});

/* Route Target */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('targetrevenue', TargetRevenueController::class);
    Route::resource('targetvolume', TargetVolumeController::class);
    Route::resource('targetdatabase', TargetDatabaseController::class);
    Route::get('get/targets', [PresenterController::class, 'get_target'])->name('presenters.target');
});

/* Route Payment */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('payment', PaymentController::class);
});

/* Route Setting */
Route::middleware(['auth', 'status:1', 'role:A'])
    ->prefix('others')
    ->group(function () {
        Route::get('/menu', [SettingController::class, 'index'])->name('menu.index');
        Route::resource('programtype', ProgramTypeController::class);
        Route::get('programtype/{id}/status', [ProgramTypeController::class, 'status'])->name('programtype.status');
        Route::resource('source', SourceController::class);
        Route::resource('fileupload', FileUploadController::class);
        Route::resource('applicantstatus', ApplicantStatusController::class);
        Route::resource('followup', FollowUpController::class);
        Route::resource('event', EventController::class);

        Route::get('event/{id}/status', [EventController::class, 'status'])->name('event.status');
        Route::get('event/{id}/scholarship', [EventController::class, 'scholarship'])->name('event.scholarship');
        Route::get('event/{id}/files', [EventController::class, 'files'])->name('event.files');  
        Route::get('event/{id}/employee', [EventController::class, 'employee'])->name('event.employee');  
        Route::get('event/{id}/program', [EventController::class, 'program'])->name('event.program');    
        Route::post('event/{id}/programstatus', [EventController::class, 'programstatus'])->name('event.programstatus');  
    });

/* Route Scholarship */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::get('questions', [HomeController::class, 'index'])->name('question.index');
    Route::get('questions/scholarship', [ResultController::class, 'index'])->name('scholarship.index');
    Route::get('questions/scholarship/questions', [QuestionController::class, 'index'])->name('scholarship.question');
});

/* Route Achievement */
Route::middleware(['auth', 'status:1'])->group(function () {
    Route::resource('achievements', AchivementController::class);
});

/* Route Organization */
Route::middleware(['auth', 'status:1'])->group(function () {
    Route::resource('organizations', OrganizationController::class);
});

require __DIR__ . '/auth.php';
