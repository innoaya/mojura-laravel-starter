<?php

namespace App\Modules\CoreModule\Http\Controllers;

use App\Modules\CoreModule\Features\Role\CreateRoleFeature;
use App\Modules\CoreModule\Features\Role\DeleteRoleFeature;
use App\Modules\CoreModule\Features\Role\IndexRoleFeature;
use App\Modules\CoreModule\Features\Role\ReadRoleFeature;
use App\Modules\CoreModule\Features\Role\UpdateRoleFeature;
use InnoAya\Mojura\Core\Controller;

class RoleController extends Controller
{
    public function index()
    {
        return $this->serve(new IndexRoleFeature);
    }

    public function create()
    {
        return $this->serve(new CreateRoleFeature);
    }

    public function read($id)
    {
        return $this->serve(new ReadRoleFeature($id));
    }

    public function update($id)
    {
        return $this->serve(new UpdateRoleFeature($id));
    }

    public function delete($id)
    {
        return $this->serve(new DeleteRoleFeature($id));
    }
}
