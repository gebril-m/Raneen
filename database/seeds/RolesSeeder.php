<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\PermissionGroup;

class RolesSeeder extends Seeder
{

    public function run()
    { 

        $groups = [
            // permissions group name => [roles take this permissions]
            'admin' => ['admin'],
            'attribute' => ['admin', 'content'],
            'brand' => ['admin', 'content'],
            'bundle' => ['admin', 'content'],
            'category' => ['admin', 'content'],
            'city' => ['admin', 'content'],
            'contactus' => ['admin', 'customer_service'],
            'country' => ['admin', 'content'],
            'cupon' => ['admin', 'merchandising'],
            'customer' => ['admin'],
            'home' => ['admin'],
            'inventory' => ['admin', 'content'],
            'location' => ['admin', 'content'],
            'log' => ['admin'],
            'manufacture' => ['admin', 'content'],
            'module' => ['admin', 'content'],
            'option' => ['admin', 'content'],
            'order' => ['admin', 'content', 'customer_service'],
            'package' => ['admin', 'content'],
            'page' => ['admin', 'graphics'],
            'product' => ['admin', 'content','customer_service'],
            'promotion' => ['admin', 'merchandising'],
            'report' => ['admin', 'content', 'customer_service'],
            'role' => ['admin'],
            'setting' => ['admin'],
            'state'=> ['admin', 'content'],
            'translation' => ['admin', 'content']
        ];

        $roles = [            
            'admin' => [],
            'content' => [],    
            // 'category' => [],
            'graphics' => [],
            'customer_service' => [],
            'merchandising' => []
        ];

        $permissionsGroups = [];

        foreach($groups as $groupName => $groupRoles){

            # insert group
            $pg = PermissionGroup::create(['name' => $groupName]);

            # permissions
            $permissions = [
                ['name' => 'view_'.$groupName, 'group_id' => $pg->id, 'guard_name'=>'web'],
                ['name' => 'create_'.$groupName, 'group_id' => $pg->id, 'guard_name'=>'web'],
                ['name' => 'edit_'.$groupName, 'group_id' => $pg->id,'guard_name'=>'web'],
                ['name' => 'delete_'.$groupName, 'group_id' => $pg->id, 'guard_name'=>'web']
            ];
            
            # insert permission
            Permission::insert($permissions);

            # ----
            foreach($groupRoles as $groupRole){
                $roles[$groupRole][] = $pg->id;
            }

        }

        # all permissions
        foreach($roles as $roleName => $groups){
            // role
            $role = Role::create(['name' => $roleName]);
            // get role related permission
            $permissions = Permission::whereIn('group_id', $groups)->get()->pluck('name');
            // sync permissions
            $role->syncPermissions( $permissions );
        }

        # assign admin role
        $user = User::find(1);
        $user->assignRole('admin');


    }
}
