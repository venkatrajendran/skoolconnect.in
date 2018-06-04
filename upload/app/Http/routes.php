<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/upgrade','upgradeController@index');
Route::post('/upgrade','upgradeController@proceed');

Route::get('/install','InstallController@index');
Route::post('/install','InstallController@proceed');

Route::get('/login','LoginController@index')->name('login');
Route::post('/login','LoginController@attemp');
Route::get('/logout','LoginController@logout');

Route::get('/forgetpwd','LoginController@forgetpwd');
Route::post('/forgetpwd','LoginController@forgetpwdStepOne');
Route::get('/forgetpwd/{uniqid}','LoginController@forgetpwdStepTwo');
Route::post('/forgetpwd/{uniqid}','LoginController@forgetpwdStepTwo');

Route::get('/register/classes','LoginController@registerClasses');
Route::get('/register/searchStudents/{student}','LoginController@searchStudents');
Route::post('/register/sectionsList','LoginController@sectionsList');

Route::get('/register/searchUsers/{usersType}/{student}','LoginController@searchUsers');

Route::get('/register','LoginController@register');
Route::post('/register','LoginController@registerPost');

Route::get('/terms','LoginController@terms');

Route::get('/licenseInstaller','LicenseController@index');
Route::post('/licenseInstaller','LicenseController@proceed');

Route::get('/preinstall', function() {
	$check = \Schema::hasTable('settings');
	if(!$check){
		return "1";
	}
});

// Dashboard

Route::group( array('middleware'=>'web') ,function(){
	Route::get('/','DashboardController@index');

	Route::post('auth/register', 'AuthController@register');
	Route::post('auth/authenticate', 'AuthController@authenticate');
	Route::get('auth/authenticate/user', 'AuthController@getAuthenticatedUser');

	Route::get('/dashboard','DashboardController@dashboardData');
	Route::get('/dashboard/baseUser','DashboardController@baseUser');
	Route::get('/calender','DashboardController@calender');
	Route::post('/dashboard/polls','DashboardController@savePolls');
	Route::get('/uploads/{section}/{image}','DashboardController@image');
    Route::post('/dashboard/changeAcYear','DashboardController@changeAcYear');
    Route::post('/dashboard/classesList','DashboardController@classesList');
    Route::post('/dashboard/subjectList','DashboardController@subjectList');
    Route::post('/dashboard/sectionsSubjectsList','DashboardController@sectionsSubjectsList');
    Route::get('/dashboard/profileImage/{id}','DashboardController@profileImage');
    Route::get('/dashboard/mobnotif','DashboardController@mobNotif');
    Route::get('/dashboard/mobnotif/{id}','DashboardController@mobNotif');
    Route::post('/dashaboard','DashboardController@dashaboardData');

	//Languages & phrases
	Route::get('/languages','DashboardController@index');
	Route::get('/languages/listAll','LanguagesController@listAll');
	Route::post('/languages','LanguagesController@create');
	Route::get('/languages/{id}','LanguagesController@fetch');
    Route::post('/languages/delete/{id}','LanguagesController@delete');
    Route::post('/languages/{id}','LanguagesController@edit');

	//Dormitories
	Route::get('/dormitories','DashboardController@index');
	Route::get('/dormitories/listAll','DormitoriesController@listAll');
	Route::post('/dormitories','DormitoriesController@create');
	Route::get('/dormitories/{id}','DormitoriesController@fetch');
    Route::post('/dormitories/delete/{id}','DormitoriesController@delete');
    Route::post('/dormitories/{id}','DormitoriesController@edit');

	//Admins
	Route::get('/admins','DashboardController@index');
	Route::get('/admins/listAll','AdminsController@listAll');
	Route::post('/admins','AdminsController@create');
	Route::get('/admins/{id}','AdminsController@fetch');
    Route::post('/admins/delete/{id}','AdminsController@delete');
    Route::post('/admins/{id}','AdminsController@edit');

	//Accountants
	Route::get('/accountants','DashboardController@index');
	Route::get('/accountants/listAll','accountantsController@listAll');
	Route::post('/accountants','accountantsController@create');
	Route::get('/accountants/{id}','accountantsController@fetch');
    Route::post('/accountants/delete/{id}','accountantsController@delete');
    Route::post('/accountants/{id}','accountantsController@edit');

	//Teachers
	Route::get('/teachers','DashboardController@index');
	Route::post('/teachers/import/{type}','TeachersController@import');
    Route::post('/teachers/reviewImport','TeachersController@reviewImport');
	Route::get('/teachers/export','TeachersController@export');
	Route::get('/teachers/exportpdf','TeachersController@exportpdf');
	Route::post('/teachers/upload','TeachersController@uploadFile');
	Route::get('/teachers/waitingApproval','TeachersController@waitingApproval');
	Route::post('/teachers/leaderBoard/{id}','TeachersController@leaderboard');
    Route::post('/teachers/approveOne/{id}','TeachersController@approveOne');
	Route::get('/teachers/profile/{id}','TeachersController@profile');
	Route::get('/teachers/listAll','TeachersController@listAll');
	Route::get('/teachers/listAll/{page}','TeachersController@listAll');
	Route::post('/teachers/listAll/{page}','TeachersController@listAll');
	Route::post('/teachers','TeachersController@create');
	Route::get('/teachers/{id}','TeachersController@fetch');
    Route::post('/teachers/leaderBoard/delete/{id}','TeachersController@leaderboardRemove');
    Route::post('/teachers/delete/{id}','TeachersController@delete');
    Route::post('/teachers/{id}','TeachersController@edit');

	//Students
	Route::get('/students','DashboardController@index');
	Route::post('/students/import/{type}','StudentsController@import');
    Route::post('/students/reviewImport','StudentsController@reviewImport');
	Route::get('/students/export','StudentsController@export');
	Route::get('/students/exportpdf','StudentsController@exportpdf');
	Route::post('/students/upload','StudentsController@uploadFile');
    Route::get('/students/waitingApproval','StudentsController@waitingApproval');
	Route::get('/students/gradStdList','StudentsController@gradStdList');
	Route::post('/students/approveOne/{id}','StudentsController@approveOne');
    Route::get('/students/print/marksheet/{student}/{exam}','StudentsController@marksheetPDF');
    Route::get('/students/marksheet/{id}','StudentsController@marksheet');
    Route::get('/students/medical/{id}','StudentsController@medical');
	Route::post('/students/medical','StudentsController@saveMedical');
	Route::get('/students/attendance/{id}','StudentsController@attendance');
	Route::get('/students/profile/{id}','StudentsController@profile');
	Route::post('/students/leaderBoard/{id}','StudentsController@leaderboard');
    Route::get('/students/listAll','StudentsController@listAll');
	Route::get('/students/listAll/{page}','StudentsController@listAll');
	Route::post('/students/listAll/{page}','StudentsController@listAll');
    Route::post('/students','StudentsController@create');
	Route::get('/students/{id}','StudentsController@fetch');
    Route::post('/students/printbulk/marksheet','StudentsController@marksheetBulkPDF');
    Route::post('/students/leaderBoard/delete/{id}','StudentsController@leaderboardRemove');
    Route::post('/students/acYear/delete/{student}/{id}','StudentsController@acYearRemove');
    Route::post('/students/delete/{id}','StudentsController@delete');
	Route::post('/students/{id}','StudentsController@edit');

	//Parents
	Route::get('/parents/search/{student}','ParentsController@searchStudents');
    Route::post('/parents/import/{type}','ParentsController@import');
    Route::post('/parents/reviewImport','ParentsController@reviewImport');
	Route::get('/parents/export','ParentsController@export');
	Route::get('/parents/exportpdf','ParentsController@exportpdf');
	Route::get('/parents','DashboardController@index');
	Route::post('/parents/upload','ParentsController@uploadFile');
	Route::get('/parents/waitingApproval','ParentsController@waitingApproval');
	Route::get('/parents/profile/{id}','ParentsController@profile');
	Route::post('/parents/approveOne/{id}','ParentsController@approveOne');
	Route::get('/parents/listAll','ParentsController@listAll');
	Route::get('/parents/listAll/{page}','ParentsController@listAll');
	Route::post('/parents/listAll/{page}','ParentsController@listAll');
	Route::post('/parents','ParentsController@create');
	Route::get('/parents/{id}','ParentsController@fetch');
    Route::post('/parents/delete/{id}','ParentsController@delete');
	Route::post('/parents/{id}','ParentsController@edit');

	//Classes
	Route::get('/classes','DashboardController@index');
	Route::get('/classes/listAll','ClassesController@listAll');
	Route::post('/classes','ClassesController@create');
	Route::get('/classes/{id}','ClassesController@fetch');
    Route::post('/classes/delete/{id}','ClassesController@delete');
	Route::post('/classes/{id}','ClassesController@edit');

    //Sections
	Route::get('/sections','DashboardController@index');
	Route::get('/sections/listAll','sectionsController@listAll');
	Route::post('/sections','sectionsController@create');
	Route::get('/sections/{id}','sectionsController@fetch');
    Route::post('/sections/delete/{id}','sectionsController@delete');
	Route::post('/sections/{id}','sectionsController@edit');

	//subjects
	Route::get('/subjects','DashboardController@index');
	Route::get('/subjects/listAll','SubjectsController@listAll');
	Route::post('/subjects','SubjectsController@create');
	Route::get('/subjects/{id}','SubjectsController@fetch');
    Route::post('/subjects/delete/{id}','SubjectsController@delete');
	Route::post('/subjects/{id}','SubjectsController@edit');

	//NewsBoard
	Route::get('/newsboard','DashboardController@index');
	Route::get('/newsboard/listAll/{page}','NewsBoardController@listAll');
    Route::get('/newsboard/search/{keyword}/{page}','NewsBoardController@search');
	Route::post('/newsboard','NewsBoardController@create');
	Route::get('/newsboard/{id}','NewsBoardController@fetch');
    Route::post('/newsboard/delete/{id}','NewsBoardController@delete');
	Route::post('/newsboard/{id}','NewsBoardController@edit');

	//Library
	Route::get('/library','DashboardController@index');
	Route::get('/library/listAll','LibraryController@listAll');
	Route::get('/library/listAll/{page}','LibraryController@listAll');
    Route::get('/library/download/{id}','LibraryController@download');
    Route::get('/library/search/{keyword}/{page}','LibraryController@search');
	Route::post('/library','LibraryController@create');
	Route::get('/library/{id}','LibraryController@fetch');
    Route::post('/library/delete/{id}','LibraryController@delete');
	Route::post('/library/{id}','LibraryController@edit');

	//Account Settings
	Route::get('/accountSettings','DashboardController@index');
	Route::get('/accountSettings/langs','AccountSettingsController@langs');
	Route::get('/accountSettings/data','AccountSettingsController@listAll');
	Route::post('/accountSettings/profile','AccountSettingsController@saveProfile');
	Route::post('/accountSettings/email','AccountSettingsController@saveEmail');
	Route::post('/accountSettings/password','AccountSettingsController@savePassword');
	Route::get('/accountSettings/invoices','AccountSettingsController@invoices');
	Route::get('/accountSettings/invoices/{id}','AccountSettingsController@invoicesDetails');

	//Class Schedule
	Route::get('/classschedule','DashboardController@index');
	Route::get('/classschedule/listAll','ClassScheduleController@listAll');
	Route::get('/classschedule/{id}','ClassScheduleController@fetch');
	Route::get('/classschedule/sub/{id}','ClassScheduleController@fetchSub');
	Route::post('/classschedule/sub/{id}','ClassScheduleController@editSub');
    Route::post('/classschedule/delete/{class}/{id}','ClassScheduleController@delete');
	Route::post('/classschedule/{id}','ClassScheduleController@addSub');

	//Site Settings
    Route::get('/settings','DashboardController@index');
	Route::get('/siteSettings/langs','SiteSettingsController@langs');
	Route::get('/siteSettings/{title}','SiteSettingsController@listAll');
	Route::post('/siteSettings/{title}','SiteSettingsController@save');

	//Attendance
    Route::get('/attendance','DashboardController@index');
	Route::get('/attendance/data','AttendanceController@listAll');
	Route::post('/attendance/list','AttendanceController@listAttendance');
	Route::post('/attendance','AttendanceController@saveAttendance');
	Route::get('/attendance/stats','AttendanceController@getStats');

	//Grade Levels
	Route::get('/gradeLevels','DashboardController@index');
	Route::get('/gradeLevels/listAll','GradeLevelsController@listAll');
	Route::post('/gradeLevels','GradeLevelsController@create');
	Route::get('/gradeLevels/{id}','GradeLevelsController@fetch');
    Route::post('/gradeLevels/delete/{id}','GradeLevelsController@delete');
	Route::post('/gradeLevels/{id}','GradeLevelsController@edit');

	//Exams List
	Route::get('/examsList','DashboardController@index');
	Route::get('/examsList/listAll','ExamsListController@listAll');
	Route::post('/examsList/notify/{id}','ExamsListController@notifications');
	Route::post('/examsList','ExamsListController@create');
	Route::get('/examsList/{id}','ExamsListController@fetch');
    Route::post('/examsList/getMarks','ExamsListController@fetchMarks');
	Route::post('/examsList/{id}','ExamsListController@edit');
    Route::post('/examsList/delete/{id}','ExamsListController@delete');
	Route::post('/examsList/saveMarks/{exam}/{class}/{subject}','ExamsListController@saveMarks');

	//Events
	Route::get('/events','DashboardController@index');
	Route::get('/events/listAll','EventsController@listAll');
	Route::post('/events','EventsController@create');
	Route::get('/events/{id}','EventsController@fetch');
    Route::post('/events/delete/{id}','EventsController@delete');
	Route::post('/events/{id}','EventsController@edit');

	//Assignments
	Route::get('/assignments','DashboardController@index');
	Route::get('/assignments/listAll','AssignmentsController@listAll');
    Route::get('/assignments/listAnswers/{id}','AssignmentsController@listAnswers');
	Route::post('/assignments','AssignmentsController@create');
    Route::get('/assignments/download/{id}','AssignmentsController@download');
    Route::get('/assignments/downloadAnswer/{id}','AssignmentsController@downloadAnswer');
    Route::get('/assignments/{id}','AssignmentsController@fetch');
    Route::post('/assignments/checkUpload','AssignmentsController@checkUpload');
    Route::post('/assignments/delete/{id}','AssignmentsController@delete');
	Route::post('/assignments/upload/{id}','AssignmentsController@upload');
	Route::post('/assignments/{id}','AssignmentsController@edit');

    //Study Material
	Route::get('/materials','DashboardController@index');
	Route::get('/materials/listAll','StudyMaterialController@listAll');
	Route::post('/materials','StudyMaterialController@create');
    Route::get('/materials/download/{id}','StudyMaterialController@download');
    Route::get('/materials/{id}','StudyMaterialController@fetch');
    Route::post('/materials/delete/{id}','StudyMaterialController@delete');
	Route::post('/materials/{id}','StudyMaterialController@edit');

	//Mail / SMS
	Route::get('/mailsms','DashboardController@index');
	Route::get('/mailsms/listAll','MailSmsController@listAll');
	Route::get('/mailsms/listAll/{page}','MailSmsController@listAll');
	Route::post('/mailsms/delete/{id}','MailSmsController@delete');
	Route::get('/mailsms/templates','MailSmsController@templates');
	Route::post('/mailsms','MailSmsController@create');
	Route::get('/mailsms/settings','MailSmsController@settings');
	Route::post('/mailsms/settings','MailSmsController@settingsSave');

    //Mobile Notifications
	Route::get('/mobileNotif','DashboardController@index');
	Route::get('/mobileNotif/listAll','mobileNotifController@listAll');
	Route::get('/mobileNotif/listAll/{page}','mobileNotifController@listAll');
	Route::post('/mobileNotif','mobileNotifController@create');
    Route::post('/mobileNotif/delete/{id}','mobileNotifController@delete');

	//Messages
	Route::get('/messages','DashboardController@index');
	Route::post('/messages','MessagesController@create');
	Route::get('/messages/listAll/{page}','MessagesController@listMessages');
    Route::get('/messages/searchUser/{user}','MessagesController@searchUser');
	Route::post('/messages/read','MessagesController@read');
	Route::post('/messages/unread','MessagesController@unread');
	Route::post('/messages/delete','MessagesController@delete');
	Route::get('/messages/{id}','MessagesController@fetch');
	Route::post('/messages/{id}','MessagesController@reply');
	Route::get('/messages/ajax/{from}/{to}/{before}','MessagesController@ajax');
	Route::get('/messages/before/{from}/{to}/{before}','MessagesController@before');

	//Online Exams
	Route::get('/onlineExams','DashboardController@index');
	Route::get('/onlineExams/listAll','OnlineExamsController@listAll');
    Route::post('/onlineExams/uploadImage','OnlineExamsController@uploadImage');
    Route::post('/onlineExams/take/{id}','OnlineExamsController@take');
	Route::post('/onlineExams/took/{id}','OnlineExamsController@took');
	Route::get('/onlineExams/marks/{id}','OnlineExamsController@marks');
	Route::get('/onlineExams/export/{id}/{type}','OnlineExamsController@export');
	Route::post('/onlineExams','OnlineExamsController@create');
	Route::get('/onlineExams/{id}','OnlineExamsController@fetch');
    Route::post('/onlineExams/delete/{id}','OnlineExamsController@delete');
	Route::post('/onlineExams/{id}','OnlineExamsController@edit');

	//Transportation
	Route::get('/transports','DashboardController@index');
	Route::get('/transports/listAll','TransportsController@listAll');
	Route::get('/transports/list/{id}','TransportsController@fetchSubs');
	Route::post('/transports','TransportsController@create');
	Route::get('/transports/{id}','TransportsController@fetch');
    Route::post('/transports/delete/{id}','TransportsController@delete');
	Route::post('/transports/{id}','TransportsController@edit');

	//Media
	Route::get('/media','DashboardController@index');
	Route::get('/media/listAll','MediaController@listAlbum');
	Route::get('/media/listAll/{id}','MediaController@listAlbumById');
	Route::get('/media/resize/{file}/{width}/{height}','MediaController@resize');
    Route::get('/media/image/{id}','MediaController@image');
	Route::post('/media/newAlbum','MediaController@newAlbum');
	Route::get('/media/editAlbum/{id}','MediaController@fetchAlbum');
	Route::post('/media/editAlbum/{id}','MediaController@editAlbum');
	Route::post('/media','MediaController@create');
	Route::get('/media/{id}','MediaController@fetch');
    Route::post('/media/album/delete/{id}','MediaController@deleteAlbum');
    Route::post('/media/delete/{id}','MediaController@delete');
    Route::post('/media/{id}','MediaController@edit');

	//Static pages
	Route::get('/static','DashboardController@index');
	Route::get('/static/listAll','StaticPagesController@listAll');
    Route::get('/static/listUser','StaticPagesController@listUser');
	Route::get('/static/active/{id}','StaticPagesController@active');
	Route::post('/static','StaticPagesController@create');
	Route::get('/static/{id}','StaticPagesController@fetch');
    Route::post('/static/delete/{id}','StaticPagesController@delete');
	Route::post('/static/{id}','StaticPagesController@edit');

	//Polls
	Route::get('/polls','DashboardController@index');
	Route::get('/polls/listAll','PollsController@listAll');
	Route::post('/polls/active/{id}','PollsController@makeActive');
	Route::post('/polls','PollsController@create');
	Route::get('/polls/{id}','PollsController@fetch');
    Route::post('/polls/delete/{id}','PollsController@delete');
	Route::post('/polls/{id}','PollsController@edit');

	//Mail / SMS Templates
	Route::get('/mailsmsTemplates','DashboardController@index');
	Route::get('/MailSMSTemplates/listAll','MailSMSTemplatesController@listAll');
	Route::get('/MailSMSTemplates/{id}','MailSMSTemplatesController@fetch');
	Route::post('/MailSMSTemplates','MailSMSTemplatesController@add');
	Route::post('/MailSMSTemplates/delete/{id}','MailSMSTemplatesController@delete');
	Route::post('/MailSMSTemplates/{id}','MailSMSTemplatesController@edit');

    //Fee Types
	Route::get('/feeTypes','DashboardController@index');
	Route::get('/feeTypes/listAll','feeTypesController@listAll');
	Route::post('/feeTypes','feeTypesController@create');
	Route::get('/feeTypes/{id}','feeTypesController@fetch');
    Route::post('/feeTypes/delete/{id}','feeTypesController@delete');
	Route::post('/feeTypes/{id}','feeTypesController@edit');

	//Fee Types
	Route::get('/feeGroups','DashboardController@index');
	Route::get('/feeGroups/listAll','feeGroupsController@listAll');
	Route::post('/feeGroups','feeGroupsController@create');
	Route::get('/feeGroups/{id}','feeGroupsController@fetch');
    Route::post('/feeGroups/delete/{id}','feeGroupsController@delete');
	Route::post('/feeGroups/{id}','feeGroupsController@edit');

    //Fee Allocation
	Route::get('/feeAllocation','DashboardController@index');
	Route::get('/feeAllocation/listAll','feeAllocationController@listAll');
	Route::post('/feeAllocation','feeAllocationController@create');
	Route::get('/feeAllocation/{id}','feeAllocationController@fetch');
	Route::get('/feeAllocation/listFeeTypes/{id}','feeAllocationController@listFeeTypes');
    Route::post('/feeAllocation/delete/{id}','feeAllocationController@delete');
	Route::post('/feeAllocation/{id}','feeAllocationController@edit');

	//invoices
	Route::get('/invoices','DashboardController@index');
	Route::get('/invoices/listAll','invoicesController@listAll');
	Route::get('/invoices/listAll/{page}','invoicesController@listAll');
    Route::post('/invoices/listAll/{page}','invoicesController@listAll');
	Route::post('/invoices/paySuccess/{id}','DashboardController@paySuccess');
	Route::get('/invoices/paySuccess','DashboardController@paySuccess');
	Route::get('/invoices/payFailed','DashboardController@payFailed');
	Route::post('/invoices/payFailed','DashboardController@payFailed');
    Route::get('/invoices/searchUsers/{student}','invoicesController@searchStudents');
    Route::get('/invoices/search/{keyword}/{page}','invoicesController@search');
	Route::get('/invoices/failed','invoicesController@paymentFailed');
	Route::get('/invoices/invoice/{id}','invoicesController@invoice');
	Route::get('/invoices/export/{id}','invoicesController@export');
	Route::get('/invoices/details/{id}','invoicesController@PaymentData');
	Route::post('/invoices','invoicesController@create');
	Route::get('/invoices/{id}','invoicesController@fetch');
	Route::post('/invoices/collect/{id}','invoicesController@collect');
	Route::post('/invoices/revert/{id}','invoicesController@revert');
	Route::post('/invoices/delete/{id}','invoicesController@delete');
	Route::post('/invoices/pay/{id}','DashboardController@pay');
	Route::post('/invoices/{id}','invoicesController@edit');

	//Expenses Cat
	Route::get('/expensesCat','expensesCatController@index');
	Route::get('/expensesCat/listAll','expensesCatController@listAll');
	Route::post('/expensesCat','expensesCatController@create');
	Route::get('/expensesCat/{id}','expensesCatController@fetch');
    Route::post('/expensesCat/delete/{id}','expensesCatController@delete');
	Route::post('/expensesCat/{id}','expensesCatController@edit');

    //Expenses
	Route::get('/expenses','expensesController@index');
	Route::get('/expenses/listAll','expensesController@listAll');
	Route::get('/expenses/listAll/{page}','expensesController@listAll');
	Route::post('/expenses','expensesController@create');
    Route::get('/expenses/download/{id}','expensesController@download');
	Route::get('/expenses/{id}','expensesController@fetch');
    Route::post('/expenses/delete/{id}','expensesController@delete');
	Route::post('/expenses/{id}','expensesController@edit');

	//Promotion
    Route::get('/promotion','DashboardController@index');
    Route::get('/promotion/search/{student}','promotionController@searchStudents');
	Route::get('/promotion/listData','promotionController@listAll');
	Route::post('/promotion/listStudents','promotionController@listStudents');
	Route::post('/promotion','promotionController@promoteNow');

    //Academic Year
    Route::get('/academicYear','DashboardController@index');
	Route::get('/academic/listAll','academicYearController@listAll');
	Route::post('/academic/active/{id}','academicYearController@active');
	Route::post('/academic','academicYearController@create');
	Route::get('/academic/{id}','academicYearController@fetch');
    Route::post('/academic/delete/{id}','academicYearController@delete');
	Route::post('/academic/{id}','academicYearController@edit');

    //Staff Attendance
	Route::get('/staffAttendance','DashboardController@index');
	Route::post('/sattendance/list','SAttendanceController@listAttendance');
	Route::post('/sattendance','SAttendanceController@saveAttendance');

    //Reports
    Route::get('/reports','DashboardController@index');
    Route::post('/reports','reportsController@report');
    Route::get('/reports/preAttendace','reportsController@preAttendaceStats');

    //vacation
    Route::get('/vacation','vacationController@index');
    Route::post('/vacation','vacationController@getVacation');
    Route::post('/vacation','vacationController@getVacation');
    Route::post('/vacation/confirm','vacationController@saveVacation');
    Route::post('/vacation/delete/{id}','vacationController@delete');

    //Hostel
	Route::get('/hostel','DashboardController@index');
	Route::get('/hostel/listAll','hostelController@listAll');
    Route::get('/hostel/listSubs/{id}','hostelController@listSubs');
	Route::post('/hostel','hostelController@create');
	Route::get('/hostel/{id}','hostelController@fetch');
    Route::post('/hostel/delete/{id}','hostelController@delete');
	Route::post('/hostel/{id}','hostelController@edit');

    //HostelCat
	Route::get('/hostelCat','DashboardController@index');
	Route::get('/hostelCat/listAll','hostelCatController@listAll');
	Route::post('/hostelCat','hostelCatController@create');
	Route::get('/hostelCat/{id}','hostelCatController@fetch');
    Route::post('/hostelCat/delete/{id}','hostelCatController@delete');
	Route::post('/hostelCat/{id}','hostelCatController@edit');


	//Vehicles
	Route::get('/vehicles','DashboardController@index');
	Route::get('/vehicles/listAll','VehiclesController@listAll');
	Route::get('/vehicles/list/{id}','VehiclesController@fetchSubs');
	Route::post('/vehicles','VehiclesController@create');
	Route::get('/vehicles/{id}','VehiclesController@fetch');
    Route::post('/vehicles/delete/{id}','VehiclesController@delete');
	Route::post('/vehicles/{id}','VehiclesController@edit');
	Route::get('/vehicles/details/{id}','VehiclesController@details');
	Route::get('/vehicles/service_cron','VehiclesController@service_cron');
});
Route::post('/invoices/success/{id}','invoicesController@paymentSuccess');
