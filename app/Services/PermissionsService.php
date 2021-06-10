<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionsService
{
    public $getCookie;
    public $permissions;
    public $strPermissions;
    public $validateResponse;

    public function __construct(Request $request)
    {
        $this->strPermissions[] = [];

        $this->getCookie = json_decode($request->cookie('policies'));
        if($this->getCookie != null){
            $this->permissions = json_decode($request->cookie('policies'))->policies->permissions;

            foreach ($this->permissions as $value) {
                $this->strPermissions[] = $value[0];
            }
        }
    }

    public function validatePermission($setPermission): string
    {
        if(in_array($setPermission, $this->strPermissions)){
            return 'ac_role:1';
        } else{
            return 'ac_role:0';
        }
    }
}
