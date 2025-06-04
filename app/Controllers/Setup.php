<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\LogModel;
use CodeIgniter\Email\Email;
use App\Libraries\MyEncrypter;


class Setup extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
    }

    public function setPassword(){
    	 $uri = service('uri');
         $flag = $uri->getSegment(3);
    	echo "disini".$flag;
    }


}

?>