<?php

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
    //return view('welcome');
    return view('candidate.landing');
})->name('welcome');




Route::get('/exam/allResults/{exam_id}', 'ExamController@exportAllResults')->name('specific.excel.results');
Route::get('/specific/candidates/{id}', 'ExamController@specificCandidatesData')->name('admin.specific.cand');
Route::post('/exam/clear_candidiates', 'ExamUserController@clearAllCandidates')->name('exam.clear.candidates');

Route::get('/view/results/{exam_id}', 'ExamUserController@adminViewResults')->name('admin.results.data');
Route::get('/show/view/results/{exam_id}', 'ExamUserController@showViewResults')->name('admin.results');
Route::delete('/exam_user/delete/{id}', 'ExamUserController@destroy')->name('admin.delete.client');
Route::post('/exam_user/reset/{id}', 'ExamUserController@resetCandidate')->name('admin.reset.client');
Route::get('/exam/data', 'ExamController@getExamData')->name('exam.data');
Route::resource('/exam', 'ExamController');

Route::get('/quest/index/{exam_id}', 'QuestionController@index')->name('quest.index');
Route::resource('/quest', 'QuestionController', ['except' => ['index']]);

Route::get('/candidates/exam/list/data', 'ExamUserController@candidateListOfExamsData')->name('candidates.exam.list.data');
Route::get('/candidates/exam/list', 'ExamUserController@candidateListOfExams')->name('candidates.exam.list');
Route::get('/candidates/index/{exam_id}', 'ExamUserController@index')->name('candidates.index');
Route::get('/candidates/{id}/edit', 'ExamUserController@edit')->name('candidates.edit');
Route::put('/candidates/{id}', 'ExamUserController@update')->name('candidates.update');
Route::post('/candidates/store', 'ExamUserController@store')->name('candidates.store');
Route::get('/candidates/test', 'ExamUserController@testExcel')->name('candidates.excel.test');
Route::get('/candidates/specific/{exam_id}', 'ExamUserController@viewList')->name('candidates.specific');
Route::get('/candidates/specific/data', 'ExamUserController@viewList')->name('candidates.specific.data');
Route::post('/candidates/login', 'ExamUserController@candidateLogin')->name('client.login');
/*
Route::get('/client/login/pg', 'ExamUserController@clientLoginPage')->name('client.login.page');
Route::get('/client/info/page', 'ExamUserController@clientInfoPage')->name('client.info.page');
Route::get('/client/logout', 'ExamUserController@candidateLogout')->name('client.logout');
*/

//Route::resource('/candid', 'ExamUserController', ['except'=> ['index']]);

Route::get('/client/test/questions', 'TestController@getQuestionData')->name('client.questions');
Route::post('/client/done/result', 'TestController@calculateResult')->name('client.result');

Auth::routes();
Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'candidate'], function () {
  Route::get('/login', 'CandidateAuth\LoginController@showLoginForm');
  Route::post('/login', 'CandidateAuth\LoginController@login');
  Route::post('/logout', 'CandidateAuth\LoginController@logout');

  Route::get('/register', 'CandidateAuth\RegisterController@showRegistrationForm');
  Route::post('/register', 'CandidateAuth\RegisterController@register');

  Route::post('/password/email', 'CandidateAuth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('/password/reset', 'CandidateAuth\ResetPasswordController@reset');
  Route::get('/password/reset', 'CandidateAuth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'CandidateAuth\ResetPasswordController@showResetForm');

  #my codes
  //Route::get('/home', 'CandidateHomeController@index')->name('candidate.home');
  Route::get('/home/data', 'CandidateHomeController@examListDT')->name('candidate.exam.list.data');
  Route::get('/instruction/{exam_id}', 'CandidateHomeController@instructionPage')->name('instruction.page');
  Route::get('/test', 'CandidateHomeController@showTest')->name('show.test');

  //candidate exam
  Route::get('/questions', 'CandidateController@getQuestionData')->name('candidate.exam.questions');
  Route::post('/results', 'CandidateController@calculateResult')->name('candidate.exam.results');
  //

  //landing page route
  // Route::get('/landing', 'CandidateAuth\LoginController');

  Route::get('/landing', function(){
    return view('candidate.landing');
    //return 'kunle';
  });
});
