<?php
namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

/**
 * 
 */
trait PermissionTrait
{
    /**
    * @param  string      $label
    * @param  string      $name
    * @param  string|null $description
    *
    * @return Role
    */
    private function createRole($label, $name, $description = null)
    {
        /** @var  Role $role */
        $role = Role::withoutGlobalScopes()
            ->updateOrCreate(
                [ 'label' => $label ],
                [
                    'description' => $name,
                ]
            );

        $role->permissions()->sync([]);

        $this->addPermissionToRole($role, $role->label, $description ?: $role->description);

        return $role;
    }

    /**
    * @param  Role   $role
    * @param  string $label
    * @param  string $description
    *
    * @return Permission
    */
    private function addPermissionToRole(Role $role, $label, $description)
    {
        /** @var  Permission $permission */
        $permission = Permission::withoutGlobalScopes()->updateOrCreate(
            [ 'label' => $label ],
            [ 'description' => $description ]
        );

        $role->permissions()->sync([ $permission->id ], false);

        return $permission;
    }

    private function addHomePermissions(
        Role $role,
        $create = true,
        $retrieve = true,
        $update = true,
        $delete = true
    ) {
        if ($create) {
            $this->addPermissionToRole($role, 'home:create', 'Criar HOME');
        }

        if ($retrieve) {
            $this->addPermissionToRole($role, 'home:index', 'Listar HOME');
        }

        if ($update) {
            $this->addPermissionToRole($role, 'home:update', 'Editar HOME');
        }

        if ($update && $delete) {
            $this->addPermissionToRole($role, 'home:destroy', 'Excluir HOME');
        }
    }

    
}
