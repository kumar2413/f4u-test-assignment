<?php

namespace App\Http\Controllers;

use App\Task;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use ShowSuite\Http\Common\Constants;

class UserController extends Controller
{
    // space that we can use the repository from
    protected $userModel;

    public function __construct(User $userModel)
    {
        // set the model
        $this->usermodel = new Repository($userModel);
    }

    public function index()
    {
        return $this->usermodel->all();
    }

    public function show($userId)
    {
        return $this->usermodel->show($userId);
    }
}
