<?php

use App\Http\Controllers\Admin\AdminAttendanceControllers;
use App\Http\Controllers\Branch\BulkUploadControllers;
use App\Http\Controllers\Branch\TaskControllers;
use App\Http\Controllers\Team\TeamTaskPulsControllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthControllers;
use App\Http\Controllers\Admin\AdminBranchControllers;
use App\Http\Controllers\Admin\AdminDashboardControllers;
use App\Http\Controllers\Admin\AdminLeadAddControllers;
use App\Http\Controllers\Admin\AdminOpsPlusController;
use App\Http\Controllers\Admin\AdminSalesControllers;
use App\Http\Controllers\Admin\AdminSubAdminControllers;
use App\Http\Controllers\Admin\AdminTeamControllers;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
   Route::get('/logout', [AdminAuthControllers::class, 'logout'])->name('logout');

    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', [AdminAuthControllers::class, 'login'])->name('login');
        Route::post('login', [AdminAuthControllers::class, 'login'])->name('admin.submit');
        Route::get('logout', [AdminAuthControllers::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => ['Admin']], function () {
        Route::get('change-password', [AdminAuthControllers::class, 'changePassword'])->name('change.password');
       
        Route::get('/dashboard', [AdminDashboardControllers::class, 'dashboard'])->name('dashboard');
        Route::get('/change-password', [AdminAuthControllers::class, 'ChangePassword'])->name('change.password');
        Route::post('/change-password-save', [AdminAuthControllers::class, 'ChangePasswordSave'])->name('change.password.save');
        
        Route::get('/department-permission', [AdminAuthControllers::class, 'departmentPermission'])->name('departmentPermission');
        Route::get('/department-role-permission', [AdminAuthControllers::class, 'rolePermission'])->name('rolePermission');
        Route::post('/save-department-role-permission', [AdminAuthControllers::class, 'saveDepartmentPermission'])->name('saveDepartmentPermission');
        
        Route::group(['prefix' => 'subadmin', 'as' => 'subadmin.'], function () {
            Route::match(['get','post'],'/sub-admin', [AdminSubAdminControllers::class, 'index'])->name('sub-admin');
            Route::get('/sub-admin-list', [AdminSubAdminControllers::class, 'list'])->name('list');
            
            Route::get('/sub-admin-update/{id}', [AdminSubAdminControllers::class, 'getSubAdminUpdate'])->name('sub-admin-get-single');
            Route::get('/sub-admin-delete/{id}', [AdminSubAdminControllers::class, 'getSubAdminDelete'])->name('delete');
            
        });

        Route::group(['prefix' => 'branch', 'as' => 'branch.'], function () {
            Route::get('/add-branch', [AdminBranchControllers::class, 'addBranch'])->name(name: 'addBranch');
            Route::post('/add-save-branch', [AdminBranchControllers::class, 'addSaveBranch'])->name('addSaveBranch');
            
            Route::get('/view-branch', [AdminBranchControllers::class, 'viewBranch'])->name('viewBranch');
            Route::get('/update-branch/{id}', [AdminBranchControllers::class, 'updateBranch'])->name('updateBranch');
            Route::get('/delete-branch/{id}', [AdminBranchControllers::class, 'deleteBranch'])->name('deleteBranch');
            
        });

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
           
            Route::get('/profile-view/{id}', [AdminTeamControllers::class, 'profileView'])->name('profileView');
            
            Route::get('/update-team/{id}', [AdminTeamControllers::class, 'updateTeam'])->name('updateTeam');
            Route::get('/delete-team/{id}', [AdminTeamControllers::class, 'deleteTeam'])->name('deleteTeam');
            
            #permission
            Route::get('/team-permission', action: [AdminTeamControllers::class, 'teamPermission'])->name('teamPermission');
            Route::post('/save-team-permission', action: [AdminTeamControllers::class, 'saveTeamPermission'])->name('saveTeamPermission');
           
        });

        Route::group(['prefix' => 'lead', 'as' => 'lead.'], function () {
            Route::get('/add-lead', [AdminLeadAddControllers::class, 'addLead'])->name('addLead');
            Route::get('/list-lead', [AdminLeadAddControllers::class, 'listLead'])->name('listLead');
            Route::post('/save-lead', [AdminLeadAddControllers::class, 'saveLead'])->name('saveLead');
            
            Route::get('/update-lead/{id}', [AdminLeadAddControllers::class, 'updateLead'])->name('updateLead');
            Route::get('/delete-lead/{id}', [AdminLeadAddControllers::class, 'deleteLead'])->name('deleteLead');
            
            Route::get('/lead-track', [AdminLeadAddControllers::class, 'leadTrack'])->name('leadTrack');
            
            Route::post('/assign-lead', [AdminLeadAddControllers::class, 'assignLead'])->name('assignLead');
            Route::post('/follow-up-lead-save', [AdminLeadAddControllers::class, 'saveFollowUpLead'])->name('saveFollowUpLead');
            
        });
       
        Route::group(['prefix' => 'task-pulse', 'as' => 'task-pulse.'], function () {
            Route::get('unassign-client', [TeamTaskPulsControllers::class, 'unassignedClient'])->name('unassignedClient');
            Route::get('task-flow-report', [TeamTaskPulsControllers::class, 'taskFlowReport'])->name('taskFlowReport');
            Route::get('not-assigned-by-manager', [TeamTaskPulsControllers::class, 'untuchedClient'])->name('untuchedClient');
            
            Route::get('task-pulse', [TeamTaskPulsControllers::class, 'taskPulse'])->name('taskPulse');
            Route::get('task-given', [TeamTaskPulsControllers::class, 'taskGiven'])->name('taskGiven');
            
            Route::get('/add-client', [AdminOpsPlusController::class, 'addClient'])->name('addClient');
            Route::post('/save-client', [AdminOpsPlusController::class, 'cSaveClient'])->name('cSaveClient');
           
            Route::get('/update-client/{id}', [AdminOpsPlusController::class, 'updateClient'])->name('updateClient');
            Route::get('/delete-client/{id}', [AdminOpsPlusController::class, 'deleteClient'])->name('deleteClient');
            
            Route::post('/move-to-team', [AdminOpsPlusController::class, 'moveToTeam'])->name('moveToTeam');
            
            #task
            Route::post('/assign-task', [AdminOpsPlusController::class, 'assignTask'])->name('assignTask');
           
        });

        Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
            Route::get('/sales-pulse-manager', [AdminSalesControllers::class, 'salePlusManager'])->name('salePlusManager');
            Route::get('/sales-pulse-team', [AdminSalesControllers::class, 'salePlusTeam'])->name('salePlusTeam');
            Route::get('/sales-pulse-report', [AdminSalesControllers::class, 'salePlusReport'])->name('salePlusReport');
            
            Route::get('/not-assigned-by-manager', [AdminSalesControllers::class, 'untouched'])->name('untouched');
            
            Route::post('/assign-team-manager', [AdminSalesControllers::class, 'assignTeamSalesManager'])->name('assignTeamSalesManager');
            
        });

         Route::group(['prefix' => 'operation', 'as' => 'opsPuls.'], function () {
            Route::post('/assign-ops-pul-manager', [AdminOpsPlusController::class, 'assignTeamOperationManager'])->name('assignTeamOperationManager');
           
            Route::get('/ops-pul-manager', [AdminOpsPlusController::class, 'OpsPulsManager'])->name('OpsPulsManager');
            Route::get('/ops-puls-team', [AdminOpsPlusController::class, 'OpsPulsTeam'])->name('OpsPulsTeam');
            Route::get('/ops-puls-report', [AdminOpsPlusController::class, 'OpsPulsReport'])->name('OpsPulsReport');
            Route::get('/add-client', [AdminOpsPlusController::class, 'addClient'])->name('addClient');
            Route::post('/save-client', [AdminOpsPlusController::class, 'cSaveClient'])->name('cSaveClient');
            
        });
        Route::group(['prefix'=> 'attendance', 'as'=> 'attendance'], function (){
            Route::post('/good-morning-good-night',  [AdminAttendanceControllers::class, 'goodMorningAttendance'])->name('goodMorningAttendance');
        });
        Route::group(['prefix' => 'upload', 'as' => 'upload.'], function () {
            Route::post('/bulkupload-lead', [BulkUploadControllers::class, 'bulkUploadLead'])->name('bulkUploadLead');
            
        });
        Route::group(['prefix'=> 'task', 'as'=> 'task.'], function (){
            Route::get('/add-task',  [TaskControllers::class, 'addTask'])->name('addTask');
            
            Route::post('/save-task',  [TaskControllers::class, 'saveTaskSubmit'])->name('saveTaskSubmit');
            
            Route::get('/list-task',  [TaskControllers::class, 'listTask'])->name('listTask');
            Route::get('/list-task-update/{id}',  [TaskControllers::class, 'listTaskUpdate'])->name('listTaskUpdate');
            Route::get('/list-task-delete/{id}',  [TaskControllers::class, 'listTaskDelete'])->name('listTaskDelete');
            

            Route::get('/reply-list/{id}',  [TaskControllers::class, 'replyView'])->name('replyView');
            
            #reply task
            Route::get('/view-task-branch-admin',  [TaskControllers::class, 'viewTaskAdminBranch'])->name('viewTaskAdminBranch');
            
        });
    });
});

Route::post('/checkMail', [AdminSubAdminControllers::class, 'checkMail'])->name('checkMail');
Route::post('/check-branch-Mail', [AdminSubAdminControllers::class, 'checkBranchMail'])->name('checkBranchMail');
Route::post('/check-team-Mail', [AdminSubAdminControllers::class, 'checkTeamMail'])->name('checkTeamMail');
Route::post('/get-designation', [AdminSubAdminControllers::class, 'getDesignation'])->name('getDesignation');
Route::post('/get-branch-country-wise', [AdminSubAdminControllers::class, 'getBranch'])->name('getBranch');
Route::post('/get-branch-country-wise1', [AdminSubAdminControllers::class, 'getBranch1'])->name('getBranch1');
Route::post('/branch-using-operation-manager', [AdminSubAdminControllers::class, 'OperationalManagerUsingBranch'])->name('branch-using-operation-manager');
Route::post('/branch-using-sales-list', [AdminSubAdminControllers::class, 'getSalesTeamBranch'])->name('getSalesTeamBranch');
           
