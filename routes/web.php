<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
    return Redirect::route('login');
});
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('adminDashboard');
});



Route::group(['prefix' => 'salesforce/leads', 'as' => 'lead.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\LeadsController::class, 'index'])->name('allLeads')->permission('view leads');
    Route::post('add-lead', [App\Http\Controllers\LeadsController::class, 'store'])->name('addLead');
    Route::post('update-lead', [App\Http\Controllers\LeadsController::class, 'update'])->name('updatelead');
    Route::post('delete-lead', [App\Http\Controllers\LeadsController::class, 'destroy'])->name('deleteLead');
    Route::get('assign-lead/{id}', [App\Http\Controllers\LeadsController::class, 'assignLead'])->name('assignLead')->permission('assign leads');
    Route::get('dispositions/{id}', [App\Http\Controllers\LeadsController::class, 'dispositions'])->name('dispositions')->permission('view dispositions');
    Route::post('assign-lead-submit', [App\Http\Controllers\LeadsController::class, 'assignLeadSubmit'])->name('assignLeadSubmit');
    Route::post('unassign-lead-submit', [App\Http\Controllers\LeadsController::class, 'unassignLeadSubmit'])->name('unassignLeadSubmit');
    Route::post('add-disposition', [App\Http\Controllers\LeadsController::class, 'addDisposition'])->name('addDisposition');
    Route::post('pinguser/{userid}/{lead_id}', [App\Http\Controllers\LeadsController::class, 'pinguser'])->name('pinguser');
    Route::get('/{id}', [App\Http\Controllers\LeadsController::class, 'show'])->name('showLead');
});

// Route::get('test',[App\Http\Controllers\AnnouncementsController::class,'importCsv']);


Route::group(['prefix' => 'salesforce/opportunities', 'as' => 'opportunity.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\OpportunityController::class, 'index'])->name('allOpportunities')->permission('view opportunities');
    Route::post('add-opportunity', [App\Http\Controllers\OpportunityController::class, 'store'])->name('addOpportunity');
    Route::post('update-opportunity', [App\Http\Controllers\OpportunityController::class, 'update'])->name('updateOpportunity');
    Route::post('delete-opportunity', [App\Http\Controllers\OpportunityController::class, 'destroy'])->name('deleteOpportunity');
    Route::get('assign-opportunity/{id}', [App\Http\Controllers\OpportunityController::class, 'assignOpportunity'])->name('assignOpportunity')->permission('assign opportunities');
    Route::post('assign-opportunity-submit', [App\Http\Controllers\OpportunityController::class, 'assignOpportunitySubmit'])->name('assignOpportunitySubmit');
    Route::post('unassign-opportunity-submit', [App\Http\Controllers\OpportunityController::class, 'unassignOpportunitySubmit'])->name('unassignOpportunitySubmit');
    Route::get('dispositions/{id}', [App\Http\Controllers\OpportunityController::class, 'dispositions'])->name('oppdispositions')->permission('view dispositions');
    Route::post('add-disposition', [App\Http\Controllers\OpportunityController::class, 'addDisposition'])->name('addDisposition');
    Route::get('/{id}', [App\Http\Controllers\OpportunityController::class, 'show'])->name('showLead');
    Route::post('pinguser/{userid}/{opportunity_id}', [App\Http\Controllers\OpportunityController::class, 'pinguser'])->name('pinguser');
});



Route::group(['prefix' => 'marketing/brands', 'as' => 'brands.', 'middleware' => ['auth', 'permission:view brands']], function () {
    Route::get('/', [App\Http\Controllers\BrandsController::class, 'index'])->name('allBrands');
    Route::post('add-brand', [App\Http\Controllers\BrandsController::class, 'store'])->name('addBrand');
    Route::post('update-brand', [App\Http\Controllers\BrandsController::class, 'update'])->name('updateBrand');
    Route::post('delete-brand', [App\Http\Controllers\BrandsController::class, 'destroy'])->name('deleteBrand');
    Route::get('/show/{id}', [App\Http\Controllers\BrandsController::class, 'show'])->name('theBrandDesc');
    Route::get('/packages/{id}', [App\Http\Controllers\BrandsController::class, 'packages'])->name('Packages');
});



Route::group(['prefix' => 'marketing/packages', 'as' => 'packages.', 'middleware' => ['auth', 'permission:view packages']], function () {
    Route::get('/', [App\Http\Controllers\PackagesController::class, 'index'])->name('allPackages');
    Route::post('add-package', [App\Http\Controllers\PackagesController::class, 'store'])->name('addPackage');
    Route::get('edit-package/{id}', [App\Http\Controllers\PackagesController::class, 'edit'])->name('editPackage');
    Route::post('update-package', [App\Http\Controllers\PackagesController::class, 'update'])->name('updatePackage');
    Route::post('delete-package', [App\Http\Controllers\PackagesController::class, 'destroy'])->name('deletePackage');
});



Route::group(['prefix' => 'admin/settings', 'as' => 'packageTypes.', 'middleware' => ['auth', 'permission:view package types']], function () {
    Route::get('/package-types', [App\Http\Controllers\PackageTypesController::class, 'index'])->name('allPackageTypes');
    Route::post('add-packagetypes', [App\Http\Controllers\PackageTypesController::class, 'store'])->name('addPackageTypes');
    Route::get('edit-packagetypes/{id}', [App\Http\Controllers\PackageTypesController::class, 'edit'])->name('editPackageTypes');
    Route::post('update-packagetypes', [App\Http\Controllers\PackageTypesController::class, 'update'])->name('updatePackageTypes');
    Route::post('delete-packagetypes', [App\Http\Controllers\PackageTypesController::class, 'destroy'])->name('deletePackageTypes');
});



Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    Route::get('myProfile', [App\Http\Controllers\ProfileController::class, 'index'])->name('myProfile');
    Route::post('editProfile', [App\Http\Controllers\ProfileController::class, 'update'])->name('editProfile');
    Route::post('additionalData', [App\Http\Controllers\ProfileController::class, 'additionalData'])->name('additionalData');
    Route::post('changePassword', [App\Http\Controllers\ProfileController::class, 'changepassword'])->name('changePassword');
});



Route::group(['prefix' => 'admin/settings', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('allRoles');
    Route::get('/roles/assign-permission/{id}', [App\Http\Controllers\RolesController::class, 'showpermissions'])->name('showPermissions');
    Route::post('/roles/assignPermission', [App\Http\Controllers\RolesController::class, 'assignPermission'])->name('assignPermission');
    Route::post('/roles/unassignPermission', [App\Http\Controllers\RolesController::class, 'unassignPermission'])->name('unassignPermission');
    Route::post('/roles/addRole', [App\Http\Controllers\RolesController::class, 'store'])->name('addRole');
    Route::post('/roles/updateRole', [App\Http\Controllers\RolesController::class, 'update'])->name('updateRole');
    Route::post('/roles/deleteRole', [App\Http\Controllers\RolesController::class, 'destroy'])->name('deleteRole');
    Route::get('/permissions', [App\Http\Controllers\PermissionsController::class, 'index'])->name('allPermissions');
    Route::get('/permissions/assign-role/{id}', [App\Http\Controllers\PermissionsController::class, 'showroles'])->name('showRoles');
    Route::post('/permissions/assignRole', [App\Http\Controllers\PermissionsController::class, 'assignRole'])->name('assignRole');
    Route::post('/permissions/unassignRole', [App\Http\Controllers\PermissionsController::class, 'unassignRole'])->name('unassignRole');
    Route::post('/permissions/addPermission', [App\Http\Controllers\PermissionsController::class, 'store'])->name('addPermission');
    Route::post('/permissions/updatePermission', [App\Http\Controllers\PermissionsController::class, 'update'])->name('updatePermission');
    Route::post('/permissions/deletePermission', [App\Http\Controllers\PermissionsController::class, 'destroy'])->name('deletePermission');

    Route::get('/holidays', [App\Http\Controllers\HolidaysController::class, 'index'])->name('allHolidays');
    Route::post('/add-holiday', [App\Http\Controllers\HolidaysController::class, 'store'])->name('addHoliday');
    Route::post('/edit-holiday', [App\Http\Controllers\HolidaysController::class, 'update'])->name('editHoliday');
    Route::post('/delete-holiday', [App\Http\Controllers\HolidaysController::class, 'destroy'])->name('deleteHoliday');
    Route::get('/leave-types', [App\Http\Controllers\LeaveTypesController::class, 'index'])->name('allLeaveTypes');
    Route::post('/add-leavetype', [App\Http\Controllers\LeaveTypesController::class, 'store'])->name('addLeaveType');
    Route::post('/edit-leavetype', [App\Http\Controllers\LeaveTypesController::class, 'update'])->name('editLeaveType');
    Route::post('/delete-leavetype', [App\Http\Controllers\LeaveTypesController::class, 'destroy'])->name('deleteLeaveType');

    Route::get('/units', [App\Http\Controllers\UnitsController::class, 'index'])->name('allUnits');
    Route::post('/add-unit', [App\Http\Controllers\UnitsController::class, 'store'])->name('addUnit');
    Route::post('update-unit', [App\Http\Controllers\UnitsController::class, 'update'])->name('updateUnit');
    Route::post('delete-unit', [App\Http\Controllers\UnitsController::class, 'destroy'])->name('deleteUnit');

    Route::get('/tax_ranges', [App\Http\Controllers\TaxController::class, 'index'])->name('allTaxes');
    Route::post('/add-tax', [App\Http\Controllers\TaxController::class, 'store'])->name('addTax');
    Route::post('/edit-tax', [App\Http\Controllers\TaxController::class, 'update'])->name('editTax');
    Route::post('/delete-tax', [App\Http\Controllers\TaxController::class, 'destroy'])->name('deleteTax');
});



Route::group(['prefix' => 'admin/settings', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/teams', [App\Http\Controllers\TeamsController::class, 'index'])->name('allTeams')->permission('view teams');
    Route::post('/add-team', [App\Http\Controllers\TeamsController::class, 'store'])->name('addTeam');
    Route::get('/show-members/{id}', [App\Http\Controllers\TeamsController::class, 'edit'])->name('showMembers');
    Route::get('/assign-brand/{id}', [App\Http\Controllers\TeamsController::class, 'assignBrandToTeam'])->name('assignBrandToTeam');
    Route::post('/delete-team', [App\Http\Controllers\TeamsController::class, 'destroy'])->name('deleteTeam');
    Route::post('/assign-member', [App\Http\Controllers\TeamsController::class, 'assignTeamMember'])->name('assignTeamMember');
    Route::post('/unassign-member', [App\Http\Controllers\TeamsController::class, 'unassignTeamMember'])->name('unassignTeamMember');
    Route::post('/assign-brand', [App\Http\Controllers\TeamsController::class, 'assignBrandSubmit'])->name('assignBrandSubmit');
    Route::post('/unassign-brand', [App\Http\Controllers\TeamsController::class, 'unassignBrandSubmit'])->name('unassignBrandSubmit');
    Route::get('/team_chart/{id}', [App\Http\Controllers\TeamsController::class, 'team_chart'])->name('teamChart');
});



Route::group(['prefix' => 'admin/settings', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/departments', [App\Http\Controllers\DepartmentsController::class, 'index'])->name('allDeparts')->permission('view department');
    Route::post('/add-department', [App\Http\Controllers\DepartmentsController::class, 'store'])->name('addDepart');
    Route::post('/delete-department', [App\Http\Controllers\DepartmentsController::class, 'destroy'])->name('deleteDepart');
    Route::post('/update-Department', [App\Http\Controllers\DepartmentsController::class, 'update'])->name('updateDepart');
});



Route::group(['prefix' => 'shifts', 'as' => 'shifts.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\ShiftsController::class, 'index'])->name('allShifts')->permission('view shifts');
    Route::post('/add-shifts', [App\Http\Controllers\ShiftsController::class, 'store'])->name('addShifts');
    Route::post('/update-shifts', [App\Http\Controllers\ShiftsController::class, 'update'])->name('updateShifts');
    Route::post('/delete-shifts', [App\Http\Controllers\ShiftsController::class, 'destroy'])->name('deleteShifts');
});



Route::group(['prefix' => 'superadmin/settings', 'as' => 'admin.', 'middleware' => ['auth', 'role:superadmin']], function () {
    Route::get('/companies', [App\Http\Controllers\CompanyController::class, 'index'])->name('allCompanies');
    Route::post('/add-company', [App\Http\Controllers\CompanyController::class, 'store'])->name('addCompany');
    Route::post('/update-company', [App\Http\Controllers\CompanyController::class, 'update'])->name('updateCompany');
    Route::post('/delete-company', [App\Http\Controllers\CompanyController::class, 'destroy'])->name('deleteCompany');
});



Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('allUsers');
    Route::get('inactive-users', [App\Http\Controllers\UserController::class, 'inactiveusers'])->name('inactiveUsers');
    Route::post('add-user', [App\Http\Controllers\UserController::class, 'store'])->name('addUser');
    Route::post('add-client', [App\Http\Controllers\UserController::class, 'addClient'])->name('addClient');
    Route::get('show-user/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('editUser');
    Route::post('update-user', [App\Http\Controllers\UserController::class, 'update'])->name('updateUser');
    Route::post('delete-user', [App\Http\Controllers\UserController::class, 'destroy'])->name('inactiveUser');
    Route::post('active-user', [App\Http\Controllers\UserController::class, 'activateUser'])->name('activeUser');
    Route::post('changePassword', [App\Http\Controllers\UserController::class, 'changepassword'])->name('changePassword');
    Route::get('roles-and-permissions/{id}', [App\Http\Controllers\UserController::class, 'rolesandpermissions'])->name('rolesandpermissions');
    Route::post('assign-user-role', [App\Http\Controllers\UserController::class, 'assignRoletoUser'])->name('assignRoletoUser');
    Route::post('unassign-user-role', [App\Http\Controllers\UserController::class, 'unassignRoletoUser'])->name('unassignRoletoUser');
    Route::post('assign-user-perm', [App\Http\Controllers\UserController::class, 'assignPermtoUser'])->name('assignPermtoUser');
    Route::post('unassign-user-perm', [App\Http\Controllers\UserController::class, 'unassignPermtoUser'])->name('unassignPermtoUser');
    Route::get('team/{id}', [App\Http\Controllers\TeamsController::class, 'show'])->name('thisTeam');
    Route::get('usercsv', [App\Http\Controllers\UserController::class, 'UserCSV'])->name('UserCSV');
});



Route::group(['prefix' => 'projects', 'as' => 'projects.', 'middleware' => ['auth']], function () {
    Route::get('opportunity_to_project/{id}', [App\Http\Controllers\ProjectsController::class, 'convert_opportunity_to_project'])->name('opportunity_to_project')->permission('convert opportunity to project');
    Route::get('/', [App\Http\Controllers\ProjectsController::class, 'index'])->name('allProjects')->permission('view projects');
    Route::post('add-project', [App\Http\Controllers\ProjectsController::class, 'store'])->name('addProject');
    Route::post('update-project', [App\Http\Controllers\ProjectsController::class, 'update'])->name('updateProject');
    Route::post('archive-project', [App\Http\Controllers\ProjectsController::class, 'destroy'])->name('archiveProject');
});

//Route::get('send', [App\Http\Controllers\HomeController::class,'sendNotification']);


Route::group(['prefix' => 'attendance', 'as' => 'attendance.', 'middleware' => ['auth']], function () {
    Route::post('/timein', [App\Http\Controllers\AttendanceController::class, 'timeIn'])->name('timeIn');
    Route::post('/timeout', [App\Http\Controllers\AttendanceController::class, 'timeOut'])->name('timeOut');
    Route::get('/user/{id}/{month}/{year}', [App\Http\Controllers\AttendanceController::class, 'attendance'])->name('userAttendance');
    Route::get('/companyattendancecsv/{month}/{year}', [App\Http\Controllers\AttendanceController::class, 'companyattendanceCSV'])->name('companyattendanceCSV');
    Route::get('/usercsv/{id}/{month}/{year}', [App\Http\Controllers\AttendanceController::class, 'attendanceCSV'])->name('attendanceCSV');
    Route::get('/company', [App\Http\Controllers\AttendanceController::class, 'datewise'])->name('companyAttendance');
    Route::get('/companycsv', [App\Http\Controllers\AttendanceController::class, 'dateWiseCSV'])->name('companyAttendanceCSV');

});



Route::group(['prefix' => 'leaves', 'as' => 'leaves.', 'middleware' => ['auth']], function () {
    Route::get('showLeaves', [App\Http\Controllers\LeavesController::class, 'index'])->name('showLeaves');
    Route::get('allLeaves', [App\Http\Controllers\LeavesController::class, 'allleaves'])->name('allLeaves');
    Route::get('companyLeaves', [App\Http\Controllers\LeavesController::class, 'companyLeaves'])->name('companyLeaves');
    Route::get('filterLeaves', [App\Http\Controllers\LeavesController::class, 'filterleaves'])->name('filterLeaves');
    Route::get('leadLeaves', [App\Http\Controllers\LeavesController::class, 'leadLeaves'])->name('leadLeaves');
    Route::get('showUserLeaves/{id}', [App\Http\Controllers\LeavesController::class, 'userleaves'])->name('showUserLeaves');
    Route::post('requestLeave', [App\Http\Controllers\LeavesController::class, 'store'])->name('requestLeave');
    Route::post('approveLeave', [App\Http\Controllers\LeavesController::class, 'approve'])->name('approveLeave');
    Route::post('rejectLeave', [App\Http\Controllers\LeavesController::class, 'reject'])->name('rejectLeave');
    Route::post('approvelead', [App\Http\Controllers\LeavesController::class, 'approvelead'])->name('approvelead');
    Route::post('rejectlead', [App\Http\Controllers\LeavesController::class, 'rejectlead'])->name('rejectlead');
    Route::get('logs', [App\Http\Controllers\LeavesController::class, 'activitylogs'])->name('logs');
    Route::post('requestLeaveajax', [App\Http\Controllers\LeavesController::class, 'leaverequestajax'])->name('requestLeaveajax');
});



Route::group(['prefix' => 'finance', 'as' => 'finance.', 'middleware' => ['auth']], function () {
    Route::get('expenses/{month}/{year}', [App\Http\Controllers\FinanceController::class, 'index'])->name('expenses');
    Route::get('expenses/{month}/{year}/{unit?}', [App\Http\Controllers\FinanceController::class, 'index'])->name('expenses');
    Route::post('addExpense', [App\Http\Controllers\FinanceController::class, 'store'])->name('addExpense');
    Route::post('searchExpense', [App\Http\Controllers\FinanceController::class, 'searhfinance'])->name('searchExpense');
});



Route::group(['prefix' => 'dispositions', 'as' => 'dispositions.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\DispositionsController::class, 'index'])->name('allDispositions');
    Route::post('/add-dispositions', [App\Http\Controllers\DispositionsController::class, 'store'])->name('addDispositions');
    Route::get('edit-packagetypes/{id}', [App\Http\Controllers\DispositionsController::class, 'edit'])->name('editDispositions');
    Route::post('update-dispositions', [App\Http\Controllers\DispositionsController::class, 'update'])->name('updateDispositions');
    Route::post('delete-dispositions', [App\Http\Controllers\DispositionsController::class, 'destroy'])->name('deleteDispositions');
});



Route::group(['prefix' => 'discrepancy', 'as' => 'discrepancy.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\DiscrepancyController::class, 'index'])->name('allDiscrepancy');
    Route::post('/add-discrepancy', [App\Http\Controllers\DiscrepancyController::class, 'store'])->name('addDiscrepancy');
    Route::post('approve-discrepancy', [App\Http\Controllers\DiscrepancyController::class, 'approveDiscrepancy'])->name('approveDiscrepancy');
    Route::post('reject-discrepancy', [App\Http\Controllers\DiscrepancyController::class, 'rejectDiscrepancy'])->name('rejectDiscrepancy');
});



Route::group(['prefix' => 'workfromhome', 'as' => 'workfromhome.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\WorkFromHomeController::class, 'index'])->name('allWorkFromHome');
    Route::post('/add-workfromhome', [App\Http\Controllers\WorkFromHomeController::class, 'store'])->name('addWorkFromHome');
    Route::post('approve-workfromhome', [App\Http\Controllers\WorkFromHomeController::class, 'approveWorkFromHome'])->name('approveWorkFromHome');
    Route::post('reject-workfromhome', [App\Http\Controllers\WorkFromHomeController::class, 'rejectWorkFromHome'])->name('rejectWorkFromHome');
});



Route::group(['prefix' => 'payroll', 'as' => 'payroll.', 'middleware' => ['auth']], function () {
    Route::get('/all', [App\Http\Controllers\PayrollController::class, 'index'])->name('allPayrolls');
    Route::get('/csv', [App\Http\Controllers\PayrollController::class, 'payrollCSV'])->name('payrollCSV');
    Route::get('/generate-payroll', [App\Http\Controllers\PayrollController::class, 'generatePayroll'])->name('generatePayroll');
});



Route::group(['prefix' => 'announcements', 'as' => 'announcements.', 'middleware' => ['auth']], function () {
    Route::post('/add-company-announcement', [App\Http\Controllers\AnnouncementsController::class, 'addCompanyAnnouncement'])->name('addCompanyAnnouncement');
    Route::post('/update-announcements', [App\Http\Controllers\AnnouncementsController::class, 'update'])->name('updateAnnouncements');
    Route::post('/delete-announcements', [App\Http\Controllers\AnnouncementsController::class, 'destroy'])->name('deleteAnnouncements');
    Route::get('/company-announcements', [App\Http\Controllers\AnnouncementsController::class, 'companyAnnouncements'])->name('companyAnnouncements');
    Route::get('/unit-announcements', [App\Http\Controllers\AnnouncementsController::class, 'unitAnnouncements'])->name('unitAnnouncements');
    Route::get('/team-announcements', [App\Http\Controllers\AnnouncementsController::class, 'teamAnnouncements'])->name('teamAnnouncements');
    Route::get('/depart-announcements', [App\Http\Controllers\AnnouncementsController::class, 'departAnnouncements'])->name('departAnnouncements');
});



Route::group(['prefix' => 'admin/fleet', 'as' => 'fleet.', 'middleware' => ['auth']], function () {
    Route::get('/all-fleet', [App\Http\Controllers\FleetController::class, 'index'])->name('allFleet')->permission('view fleet');
    Route::get('/fleet-csv', [App\Http\Controllers\FleetController::class, 'fleetCSV'])->name('fleetCSV')->permission('view fleet');
    Route::post('add-fleet', [App\Http\Controllers\FleetController::class, 'store'])->name('addFleet');
    Route::get('edit-fleet/{id}', [App\Http\Controllers\FleetController::class, 'edit'])->name('editFleet')->permission('update fleet');
    Route::post('update-fleet', [App\Http\Controllers\FleetController::class, 'update'])->name('updateFleet');
    Route::post('delete-fleet', [App\Http\Controllers\FleetController::class, 'destroy'])->name('deleteFleet');
    Route::get('my-fleet', [App\Http\Controllers\FleetController::class, 'myFleet'])->name('myFleet');
    Route::post('update-kilometer', [App\Http\Controllers\FleetController::class, 'updateKilometer'])->name('updateKilometer');
    Route::post('request-maintainance', [App\Http\Controllers\FleetMaintainanceController::class, 'store'])->name('requestMaintainance');
    Route::get('maintainance-requests', [App\Http\Controllers\FleetMaintainanceController::class, 'index'])->name('MaintainanceRequests');
});
