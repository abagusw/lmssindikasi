<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Home');
$routes->get('/', 'Auth::index');
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
//Routes email
$routes->get('email/testEmail', 'SendEmailCon::testEmail');
$routes->get('email/templateEmail', 'SendEmailCon::templateEmail');
$routes->get('email/kirimEmailApprove/(:segment)', 'SendEmailCon::kirimEmailApprove/$1');
$routes->get('email/kirimEmailReject/(:segment)', 'SendEmailCon::kirimEmailReject/$1');

$routes->get('/midtrans/token', 'MidtransController::token');
$routes->get('/midtrans/checkout', function() {
    return view('coba_midtrans/midtrans_checkout');
});

$routes->get('paymentXXX/pay','MidtransController::index');

$routes->get('setup/setpassword','Setup::setPassword');


$routes->group('/', ['filter' => 'auth'], function ($routes) {

	$routes->get('auth/logout', 'Auth::logout');

	$routes->get('dashboard', 'Dashboard::index');

	$routes->get('user/profile', 'User::profile');
	$routes->patch('user/(:segment)/changeprofile', 'User::changeProfile/$1');

	$routes->get('user/new', 'User::new');
	$routes->post('user', 'User::create');
	$routes->get('user', 'User::index');
	$routes->get('user/(:segment)/edit', 'User::edit/$1');
	$routes->patch('user/(:segment)', 'User::update/$1');
	$routes->delete('user/(:segment)', 'User::delete/$1');
	$routes->patch('user/(:segment)/changestatus', 'User::changeStatus/$1');

	//Routes member Reg//
	$routes->get('member/user/(:any)','Member::index/$1');
	
	$routes->post('member/getDataMember/(:any)','Member::getDataMember/$1');
	$routes->post('member/getDataMemberReg','Member::getDataMemberReg');
	$routes->get('member/registration','Member::indexReg');
	
	$routes->get('member/getDataMemberDetail/(:segment)','Member::getDataMemberDetail/$1');
	$routes->post('member/ubahStatus','Member::ubahStatus');
	$routes->get('member/templateEmail','Member::templateEmail');


	


	//Routes Master //
	$routes->get('master/branch','Master::branch');
	$routes->get('master/add_branch','Master::add_branch');
	$routes->get('master/edit_branch/(:segment)','Master::edit_branch/$1');
	$routes->post('master/simpanBranch','Master::simpanBranch');
	$routes->post('master/simpanEditBranch','Master::simpanEditBranch');
	$routes->post('master/hapusDataBranch','Master::hapusDataBranch');

	//Routes Master City //
	$routes->get('master/city','Master::city');
	$routes->get('master/add_city','Master::add_city');
	$routes->get('master/edit_city/(:segment)','Master::edit_city/$1');
	$routes->post('master/simpanCity','Master::simpanCity');
	$routes->post('master/simpanEditCity','Master::simpanEditCity');
	$routes->post('master/hapusDataCity','Master::hapusDataCity');


	//Routes Payment//
	$routes->get('payment/index','Payment::index');
	$routes->post('payment/getPayment','Payment::getPayment');



	

});

