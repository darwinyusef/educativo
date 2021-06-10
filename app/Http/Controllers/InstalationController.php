<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Exception;
use InvalidArgumentException;


class InstalationController extends Controller
{
    function welcomeInstalation()
    {
    }

    /**
     *  Ejecuta la instalación inicial
     */
    function getInstalation(Request $request)
    {
        if (filter_var($request->initiation) == true) {

            try {
                $this->rolesInstalation();
                $this->permissionInstalation();
                $this->rolesHasPermissionInstalation();
                $this->roleFirstUser();
            } catch (Exception $e) {
                throw new InvalidArgumentException('No se han instalado correctamente los datos');
                return false;
            }

            return true;
        }
    }

    /**
     *  Construye el listado de roles de la aplicación
     */
    function rolesInstalation()
    {

        DB::beginTransaction();

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Role::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            Role::create(['guard_name' => 'web', 'name' => 'admin']);
            Role::create(['guard_name' => 'web', 'name' => 'user']);
            Role::create(['guard_name' => 'web', 'name' => 'student']);
            Role::create(['guard_name' => 'web', 'name' => 'teacher']);
            Role::create(['guard_name' => 'web', 'name' => 'contributor']);
            Role::create(['guard_name' => 'web', 'name' => 'author']);
            Role::create(['guard_name' => 'api', 'name' => 'student']);
            Role::create(['guard_name' => 'api', 'name' => 'teacher']);
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('Error al enviar los datos');
        }

        DB::commit();
    }

    /**
     *  Construye el listado de permisos de la aplicación
     */
    function permissionInstalation()
    {

        DB::beginTransaction();

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Permission::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $guards = ['web']; //, 'mobile'
            $permissions = [
                // instalation
                'install:admin',
                // users
                'create:user', 'store:user', 'update:user', 'delete:user', 'auto.delete:user',
                'deleteForever:user', 'collection:user', 'find:user', 'restore:user',
                // multimedia
                'chargue:file', 'create:files', 'store:files', 'update:files', 'delete:files',
                'deleteForever:files', 'collection:files', 'find:files', 'restore:files',
                // post
                'create:post', 'store:post', 'update:post', 'delete:post',
                'deleteForever:post', 'collection:post', 'find:post', 'restore:post'
            ];


            foreach ($guards as $guard) {
                foreach ($permissions as $permision) {
                    $model = [null, $permision, $guard, Carbon::now()->toDateTimeString(), Carbon::now()->toDateTimeString()];

                    DB::insert('insert into permissions (id, name, guard_name, created_at, updated_at) values (?, ?, ?, ?, ?)', $model);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('Error al enviar los datos');
        }

        DB::commit();
    }


    /**
     *  Asigna al administrador el id permiso / roles de la aplicación
     */
    function rolesHasPermissionInstalation()
    {
        $data = [
            // 1 admin
            [1, 1], [2, 1], [3, 1], [4, 1], [5, 1], [6, 1], [7, 1], [8, 1], [9, 1],
            [10, 1], [11, 1], [12, 1], [13, 1], [14, 1], [15, 1], [16, 1], [17, 1], [18, 1],
            [19, 1], [20, 1], [21, 1], [22, 1], [23, 1], [24, 1], [25, 1], [26, 1], [27, 1],
            // 2 user
            [3, 2], [4, 2], [6, 2]
        ];

        DB::beginTransaction();

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('role_has_permissions')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            for ($i = 0; $i < 30; $i++) {
                DB::insert('insert into role_has_permissions (permission_id, role_id) values (?, ?)', $data[$i]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('Error al enviar los datos');
        }

        DB::commit();
    }

    function roleFirstUser()
    {
        $data = [
            [1, 1, 'App\Models\User'], [2, 1, 'App\Models\User']
        ];
        for ($i = 0; $i < 1; $i++) {
            DB::insert('insert into model_has_roles (role_id, model_id, model_type) values (?, ?, ?)', $data[$i]);
        }
    }
}
