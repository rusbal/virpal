<?php

namespace DTApi\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected function adminOrSuperAdmin($request) 
    {
        return $request->__authenticatedUser->user_type == env('ADMIN_ROLE_ID') 
            || $request->__authenticatedUser->user_type == env('SUPERADMIN_ROLE_ID');
    }

    protected function getFromRequest(Request $request, $key, $default = "")
    {
        return $request->get($key) ?: $default;
    }

    protected function convertTrueToYesNo(Request $request, $key, $default = 'no')
    {
        return $request->get($key) == 'true' ? 'yes' : $default;
    }
}
