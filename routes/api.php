<?php

use App\Http\Controllers\API\Dashboard\RegisterProgramController;
use App\Http\Controllers\API\Dashboard\RekapPerolehanPMB;
use App\Http\Controllers\API\Dashboard\SalesController;
use App\Http\Controllers\API\RecommendationController;
use App\Http\Controllers\API\Report\RegisterByProgramController;
use App\Http\Controllers\API\Report\RegisterBySchoolController;
use App\Http\Controllers\API\Report\RegisterBySourceController;
use App\Http\Controllers\API\Report\ReportStudentsAdmissionController;
use App\Http\Controllers\API\Report\TargetByMonthController;
use App\Http\Controllers\API\Report\TargetByPresenterController;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\Target\VolumeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApplicantController;
use App\Http\Controllers\API\Report\RegisterBySchoolYearController;
use App\Http\Controllers\API\Report\ReportAplikanController;
use App\Http\Controllers\API\Report\SourceDatabaseByPresenterController;
use App\Http\Controllers\API\Report\SourceDatabaseByWilayahController;
use App\Http\Controllers\API\Report\WilayahDatabaseByPresenterController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/applicants/scholarships', [ApplicantController::class, 'get_scholarship']);

Route::get('/school/getall', [SchoolController::class, 'get_all'])->name('school.getall');
Route::get('/database/{identity}', [ApplicantController::class, 'show'])->name('applicants.api.show');

Route::get('/report/database/presenter/source', [SourceDatabaseByPresenterController::class, 'get_all']);
Route::get('/report/database/wilayah/source', [SourceDatabaseByWilayahController::class, 'get_all']);

Route::get('/report/database/presenter/wilayah', [WilayahDatabaseByPresenterController::class, 'get_all']);

Route::get('/report/database/aplikan/aplikan', [ReportAplikanController::class, 'aplikan']);
Route::get('/report/database/aplikan/daftar', [ReportAplikanController::class, 'daftar']);
Route::get('/report/database/aplikan/registrasi', [ReportAplikanController::class, 'registrasi']);
Route::get('/report/database/aplikan/files', [ReportAplikanController::class, 'files']);

Route::get('/report/database/perolehanpmb', [ReportStudentsAdmissionController::class, 'get_all']);

Route::get('/report/database/register/school', [RegisterBySchoolController::class, 'get_all']);
Route::get('/report/database/register/program', [RegisterByProgramController::class, 'get_all']);
Route::get('/report/database/register/school/year', [RegisterBySchoolYearController::class, 'get_all']);
Route::get('/report/database/register/source', [RegisterBySourceController::class, 'get_all']);
Route::get('/report/database/target/presenter', [TargetByPresenterController::class, 'get_all']);
Route::get('/report/database/target/month', [TargetByMonthController::class, 'get_all']);

Route::get('/target/volume/getvolumes', [VolumeController::class, 'get_volumes'])->name('volume.get_volumes');
Route::get('/target/volume/getrevenues', [VolumeController::class, 'get_revenues'])->name('volume.get_revenues');
Route::get('/target/volume/getdatabases', [VolumeController::class, 'get_databases'])->name('volume.get_databases');

Route::get('/dashboard/register/program', [RegisterProgramController::class, 'get_all']);
Route::get('/dashboard/register/rekapperolehanpmb', [RekapPerolehanPMB::class, 'get_all']);
Route::get('/dashboard/sales', [SalesController::class, 'get_all']);

Route::get('/recommendation', [RecommendationController::class, 'get_all']);

Route::post('/resetpassword', [ResetPasswordController::class, 'reset']);