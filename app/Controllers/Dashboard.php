<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MemberModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
    }

    public function index()
    {
        $year = (int)($this->request->getGet('year') ?? date('Y'));

        $m = $this->memberModel;
        $data = [
            'title' => 'Dashboard',
            'user_logged_in' => $this->userModel->find($this->session->get('id')),
            'session' => \Config\Services::session(),
            'year'              => $year,
            'totalRegister'     => $m->totalRegister(),
            'totalActive'       => $m->totalActive(),
            'newRegisterMonth'  => $m->newRegisterThisMonth(),
            'topCities'         => $m->topCitiesActive(10),
            'topProfesi'        => $m->topProfesiActive(10),
            'seriesRegister'    => array_values($m->monthlyRegistration($year)),
            'seriesActive'      => array_values($m->monthlyActivation($year)),
            'monthLabels'       => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        ];

        return view('dashboard/index', $data);
    }

    //--------------------------------------------------------------------

}
