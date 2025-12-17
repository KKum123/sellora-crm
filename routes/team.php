

<?php

use App\Http\Controllers\Admin\AdminAttendanceControllers;
use App\Http\Controllers\Admin\AdminDashboardControllers;
use App\Http\Controllers\Admin\AdminLeadAddControllers;
use App\Http\Controllers\Admin\AdminOpsPlusController;
use App\Http\Controllers\Admin\AdminSalesControllers;
use App\Http\Controllers\Admin\AdminTeamControllers;
use App\Http\Controllers\Branch\BulkUploadControllers;
use App\Http\Controllers\Branch\TaskControllers;
use App\Http\Controllers\Team\HR\HREmployeeManagementController;
use App\Http\Controllers\Team\HR\HRPayrollController;
use App\Http\Controllers\Team\HR\HRPerformanceManagementController;
use App\Http\Controllers\Team\HR\HRRecruitmentManagementController;
use App\Http\Controllers\Team\HR\HRTrainingDevelopementController;
use App\Http\Controllers\Team\TeamAuthControllers;
use App\Http\Controllers\Team\TeamTaskPulsControllers;
use Illuminate\Support\Facades\Route;



Route::group(['namespace' => 'Team', 'prefix' => 'team', 'as' => 'team.'], function () {
    Route::get('/logout', [TeamAuthControllers::class, 'logout'])->name('logout');
    Route::get('login', [TeamAuthControllers::class, 'login'])->name('login');
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', [TeamAuthControllers::class, 'login'])->name('login');
        Route::post('login', [TeamAuthControllers::class, 'login'])->name('branch.submit');
        Route::get('logout', [TeamAuthControllers::class, 'logout'])->name('');
    });

    Route::group(['middleware' => ['Team']], function () {
        Route::get('change-password', [TeamAuthControllers::class, 'changePassword'])->name('change.password');
        Route::post('/change-password-save', [TeamAuthControllers::class, 'ChangePasswordSave'])->name('change.password.save');
        
        Route::get('/dashboard', [AdminDashboardControllers::class, 'dashboard'])->name('dashboard');
       
       #add Team
       Route::group(['prefix' => 'team', 'as' => 'team.'], function () {
            Route::get('/add-team', [AdminTeamControllers::class, 'addTeam'])->name('addTeam');
            Route::post('/save-team', [AdminTeamControllers::class, 'saveTeam'])->name('saveTeam');
            Route::post('/save-team-profile', [AdminTeamControllers::class, 'savePersonalInTeam'])->name('savePersonalInTeam');
            Route::post('/save-team-family', [AdminTeamControllers::class, 'saveTeamFamily'])->name('saveTeamFamily');
            Route::post('/save-team-education', [AdminTeamControllers::class, 'saveTeamEducation'])->name('saveTeamEducation');
            Route::post('/save-team-experience', [AdminTeamControllers::class, 'saveExperienceTeam'])->name('saveExperienceTeam');
            
            Route::get('/profile-family-delete/{id}', [AdminTeamControllers::class, 'deleteFamily'])->name('deleteFamily');
            Route::get('/profile-education-delete/{id}', [AdminTeamControllers::class, 'deleteEducation'])->name('deleteEducation');
            Route::get('/profile-experience-delete/{id}', [AdminTeamControllers::class, 'deleteExperience'])->name('deleteExperience');
            
            Route::get('/list-team', [AdminTeamControllers::class, 'listTeam'])->name('listTeam');
            

            Route::get('/profile-view/{id}', [AdminTeamControllers::class, 'profileView'])->name(name: 'profileView');
            

            Route::get('/update-team/{id}', [AdminTeamControllers::class, 'updateTeam'])->name('updateTeam');
            Route::get('/delete-team/{id}', [AdminTeamControllers::class, 'deleteTeam'])->name('deleteTeam');
        
             #permission
             Route::get('/team-permission', action: [AdminTeamControllers::class, 'teamPermission'])->name('teamPermission');
             Route::post('/save-team-permission', action: [AdminTeamControllers::class, 'saveTeamPermission'])->name('saveTeamPermission');
            
        });
      #end team

        Route::group(['prefix' => 'lead', 'as' => 'lead.'], function () {
            Route::get('/add-lead', [AdminLeadAddControllers::class, 'addLead'])->name('addLead');
            Route::get('/list-lead', [AdminLeadAddControllers::class, 'listLead'])->name('listLead');
            Route::post('/save-lead', [AdminLeadAddControllers::class, 'saveLead'])->name('saveLead');

            Route::get('/update-lead/{id}', [AdminLeadAddControllers::class, 'updateLead'])->name('updateLead');
            Route::get('/delete-lead/{id}', [AdminLeadAddControllers::class, 'deleteLead'])->name('deleteLead');

            Route::get('/lead-track', [AdminLeadAddControllers::class, 'leadTrack'])->name('leadTrack');
            Route::get('/my-lead', [AdminLeadAddControllers::class, 'myLead'])->name('myLead');
            Route::get('/my-lead', [AdminLeadAddControllers::class, 'myLead'])->name('myLead');
            
            Route::post('/assign-lead', [AdminLeadAddControllers::class, 'assignLead'])->name('assignLead');
            Route::post('/follow-up-lead-save', [AdminLeadAddControllers::class, 'saveFollowUpLead'])->name('saveFollowUpLead');
            
        });

        Route::group(['prefix' => 'task-pulse', 'as' => 'task-pulse.'], function () {
            Route::get('unassign-client', [TeamTaskPulsControllers::class, 'unassignedClient'])->name('unassignedClient');
            Route::get('task-flow-report', [TeamTaskPulsControllers::class, 'taskFlowReport'])->name('taskFlowReport');
            Route::get('task-pulse', [TeamTaskPulsControllers::class, 'taskPulse'])->name('taskPulse');
            Route::get('task-given', [TeamTaskPulsControllers::class, 'taskGiven'])->name('taskGiven');
            
            Route::get('not-assigned-by-manager', [TeamTaskPulsControllers::class, 'untuchedClient'])->name('untuchedClient');
            
            Route::get('/add-client', [AdminOpsPlusController::class, 'addClient'])->name('addClient');
            
            Route::post('/save-client', [AdminOpsPlusController::class, 'cSaveClient'])->name('cSaveClient');
           
            Route::get('/update-client/{id}', [AdminOpsPlusController::class, 'updateClient'])->name('updateClient');
            Route::get('/delete-client/{id}', [AdminOpsPlusController::class, 'deleteClient'])->name('deleteClient');
            
            Route::post('/move-to-team', [AdminOpsPlusController::class, 'moveToTeam'])->name('moveToTeam');
            #task
            Route::post('/assign-task', [AdminOpsPlusController::class, 'assignTask'])->name('assignTask');
           
        });

        Route::group(['prefix' => 'operation', 'as' => 'opsPuls.'], function () {
            Route::post('/assign-ops-pul-manager', [AdminOpsPlusController::class, 'assignTeamOperationManager'])->name('assignTeamOperationManager');
           
            Route::get('/ops-pul-manager', [AdminOpsPlusController::class, 'OpsPulsManager'])->name('OpsPulsManager');
            Route::get('/ops-puls-team', [AdminOpsPlusController::class, 'OpsPulsTeam'])->name('OpsPulsTeam');
            Route::get('/ops-puls-report', [AdminOpsPlusController::class, 'OpsPulsReport'])->name('OpsPulsReport');
           
            #task
           
           Route::post('/reply-submit', [TeamTaskPulsControllers::class, 'taskReply'])->name('taskReply');
          
        });

        #hr panel
        Route::group(['prefix' => 'employee-management', 'as' => 'opsPemployeeManagementuls.'], function () {
            Route::get('/onboarding', [AdminTeamControllers::class, 'addTeam'])->name('addTeam');
            Route::post('/save-team', [AdminTeamControllers::class, 'saveTeam'])->name('saveTeam');
            Route::get('/list-team', [AdminTeamControllers::class, 'listTeam'])->name('listTeam');
            
            Route::get('/update-team/{id}', [AdminTeamControllers::class, 'updateTeam'])->name('updateTeam');
            Route::get('/delete-team/{id}', [AdminTeamControllers::class, 'deleteTeam'])->name('deleteTeam');
        
             #permission
            Route::get('/team-permission', action: [AdminTeamControllers::class, 'teamPermission'])->name('teamPermission');
            Route::post('/save-team-permission', action: [AdminTeamControllers::class, 'saveTeamPermission'])->name('saveTeamPermission');
            #ex employee

            Route::get('/ex-employee', action: [HREmployeeManagementController::class, 'exEmployee'])->name('exEmployee');
            Route::get('/exit-interview', action: [HREmployeeManagementController::class, 'exitInterview'])->name('exitInterview');
            
            Route::post('/save-exit-interview', action: [HREmployeeManagementController::class, 'saveExitInterview'])->name('saveExitInterview');
            

        });
        Route::group(['prefix' => 'performance-management', 'as' => 'performanceManagementuls.'], function () {
            Route::get('/goal-setting', action: [HRPerformanceManagementController::class, 'goalSetting'])->name('goalSetting');
            Route::post('/save-goal-setting', action: [HRPerformanceManagementController::class, 'saveGoalSetting'])->name('saveGoalSetting');
            
            Route::get('/performance-review', action: [HRPerformanceManagementController::class, 'performanceReview'])->name('performanceReview');
            Route::post('/save-performance-review', action: [HRPerformanceManagementController::class, 'savePerformanceReview'])->name('savePerformanceReview');
            
            Route::get('/employee-recognition', action: [HRPerformanceManagementController::class, 'employeeRecognition'])->name('employeeRecognition');
            Route::post('/employee-recognition-save', action: [HRPerformanceManagementController::class, 'saveEmployeeRecognition'])->name('saveEmployeeRecognition');
           
        });
        Route::group(['prefix' => 'payroll', 'as' => 'Payroll.'], function () {
            Route::get('/attendance', action: [HRPayrollController::class, 'attendance'])->name('attendance');
            Route::get('/get-calander', action: [HRPayrollController::class, 'getCalander'])->name('getCalander');
            
            Route::get('/employee-salary', action: [HRPayrollController::class, 'employeeSalary'])->name('employeeSalary');
            Route::get('/bonuses-and-incentives', action: [HRPayrollController::class, 'bonusesAndIncentives'])->name('bonusesAndIncentives');
            Route::post('/bonuses-and-incentives-save', action: [HRPayrollController::class, 'bonusesAndIncentivesSave'])->name('bonusesAndIncentivesSave');
            
            Route::get('/leave-management', action: [HRPayrollController::class, 'leaveManagement'])->name('leaveManagement');
            Route::post('/add-leave', action: [HRPayrollController::class, 'addLeave'])->name('add.leave');
            
        });
        Route::group(['prefix' => 'training-and-development', 'as' => 'trainingDevelopment.'], function () {
            Route::get('/lms',  [HRTrainingDevelopementController::class, 'lms'])->name('lms');
            Route::get('/lms-get/{id}',  [HRTrainingDevelopementController::class, 'lmsGet'])->name('lmsGet');
            Route::get('/lms-delete/{id}',  [HRTrainingDevelopementController::class, 'lmsDelete'])->name('lmsDelete');
           
            Route::post('/save-lms',  [HRTrainingDevelopementController::class, 'lmsSave'])->name('lmsSave');
           
            Route::get('/new-hires',  [HRTrainingDevelopementController::class, 'newHires'])->name('newHires');
            Route::post('/save-new-hires',  [HRTrainingDevelopementController::class, 'saveNewHires'])->name('saveNewHires');
            Route::get('/delete-new-hires/{id}', [HRTrainingDevelopementController::class, 'deleteNewHires'])->name('deleteNewHires');
            
        });
        Route::group(['prefix' => 'recruitment-management', 'as' => 'recruitmentManagement.'], function () {
            Route::get('/candidate-info', [HRRecruitmentManagementController::class, 'candidateInfo'])->name('candidateInfo');
            Route::post('/save-candidate-info',  [HRRecruitmentManagementController::class, 'saveCandidateInfo'])->name('saveCandidateInfo');
           
            Route::get('/interview-status',  [HRRecruitmentManagementController::class, 'interviewStatus'])->name('interviewStatus');
            Route::get('/update-interview-status/{id}',  [HRRecruitmentManagementController::class, 'getInterviewStatus'])->name('getInterviewStatus');
            
            Route::post('/change-interview-status',  [HRRecruitmentManagementController::class, 'changeInterviewStatus'])->name('changeInterviewStatus');
            
        });
        Route::group(['prefix'=> 'attendance', 'as'=> 'attendance.'], function (){
            Route::post('/good-morning-good-night',  [AdminAttendanceControllers::class, 'goodMorningAttendance'])->name('goodMorningAttendance');
        });
        Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
            Route::get('/sales-pulse-manager', [AdminSalesControllers::class, 'salePlusManager'])->name('salePlusManager');
            Route::get('/sales-pulse-team', [AdminSalesControllers::class, 'salePlusTeam'])->name('salePlusTeam');
            Route::get('/sales-pulse-report', [AdminSalesControllers::class, 'salePlusReport'])->name('salePlusReport');
            
            Route::post('/assign-team-manager', [AdminSalesControllers::class, 'assignTeamSalesManager'])->name('assignTeamSalesManager');
            
            Route::get('/not-assigned-by-manager', [AdminSalesControllers::class, 'untouched'])->name('untouched');
            
        });
        
       #Attendance report
        Route::get('/view-attendance-team',  [AdminAttendanceControllers::class, 'attendanceReport'])->name(name: 'attendanceReport');
        
        Route::group(['prefix' => 'upload', 'as' => 'upload.'], function () {
            Route::post('/bulkupload-lead', [BulkUploadControllers::class, 'bulkUploadLead'])->name('bulkUploadLead');
            
        });

        Route::group(['prefix'=> 'task', 'as'=> 'task.'], function (){
             #reply task
             Route::get('/reply-list/{id}',  [TaskControllers::class, 'replyView'])->name('replyView');
            
             Route::get('/view-task-branch-admin',  [TaskControllers::class, 'viewTaskAdminBranch'])->name('viewTaskAdminBranch');
             Route::post('/reply-task-branch-admin',  [TaskControllers::class, 'replyTaskAdminBranch'])->name('replyTaskAdminBranch');
       
            });
    });

    Route::post('/fetch-team',  [AdminDashboardControllers::class, 'fetchTeam'])->name(name: 'fetchTeam');
         
});


      
