<?php

namespace App\Modules\CoreModule\Http\Controllers;

use App\Modules\CoreModule\Features\GetOptionDataFeature;
use InnoAya\Mojura\Core\Controller;

class OptionDataController extends Controller
{
    public function get($key)
    {
        return $this->serve(new GetOptionDataFeature($key));
    }
}
