<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\User;
use App\Traits\PermissionTrait;

class ACLAdminSeed extends Seeder
{
    use PermissionTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addHomeRoles();
    }

    private function addHomeRoles()
    {
        
        $role = $this->createRole(Role::ADMIN, 'Administrador', 'Administrador do sistema');
        $this->addHomePermissions($role, false, true, false, false);
        $user = User::find(1);
        $user->attachRole($role);
    }

    
}
