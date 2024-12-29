<?php

namespace App\Modules\CoreModule\Http\Controllers;

use App\Modules\CoreModule\Features\Auth\LoginUserFeature;
use App\Modules\CoreModule\Features\Auth\LogoutAllFeature;
use App\Modules\CoreModule\Features\Auth\LogoutUserFeature;
use Illuminate\Support\Facades\Auth;
use InnoAya\Mojura\Core\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return $this->serve(new LoginUserFeature);
    }

    public function logout()
    {
        return $this->serve(new LogoutUserFeature);
    }

    public function logoutAll()
    {
        // Logout of all sessions
        return $this->serve(new LogoutAllFeature(Auth::id()));
    }
}
