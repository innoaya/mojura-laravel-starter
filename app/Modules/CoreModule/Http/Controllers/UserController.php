<?php

namespace App\Modules\CoreModule\Http\Controllers;

use App\Modules\CoreModule\Features\Auth\GetProfileFeature;
use App\Modules\CoreModule\Features\Auth\UpdateProfileFeature;
use App\Modules\CoreModule\Features\User\CreateUserFeature;
use App\Modules\CoreModule\Features\User\DeleteUserFeature;
use App\Modules\CoreModule\Features\User\IndexUserFeature;
use App\Modules\CoreModule\Features\User\ReadUserFeature;
use App\Modules\CoreModule\Features\User\UpdateUserFeature;
use InnoAya\Mojura\Core\Controller;

class UserController extends Controller
{
    /**
     * Show Authenticated User Information.
     */
    public function getProfile()
    {
        return $this->serve(new GetProfileFeature);
    }

    /**
     * Update Authenticated User Profile Information.
     */
    public function updateProfile()
    {
        return $this->serve(new UpdateProfileFeature);
    }

    public function index()
    {
        return $this->serve(new IndexUserFeature);
    }

    public function create()
    {
        return $this->serve(new CreateUserFeature);
    }

    public function read($id)
    {
        return $this->serve(new ReadUserFeature($id));
    }

    public function update($id)
    {
        return $this->serve(new UpdateUserFeature($id));
    }

    public function delete($id)
    {
        return $this->serve(new DeleteUserFeature($id));
    }
}
