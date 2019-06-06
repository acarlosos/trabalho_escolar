<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Role extends Model
{
    use SoftDeletes;

    const ADMIN      = 'admin';

    protected $table      = 'roles';

    protected $fillable = [
        'label',
        'description',
    ];

    protected $casts = [
        'id'         => 'integer',
    ];



    protected $dates = [ 'deleted_at' ];

    public function permissions()
    {
        return $this->belongsToMany( Permission::class, 'permission_role' )->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany( User::class, 'role_user' )->withTimestamps();
    }

    public function attachPermission( Permission $permission )
    {
        unset( $this->permissions );
        unset( $permission->roles );
        unset( $permission->users );
        $this->permissions()->attach( $permission->id );
        $this->rebuildUsersPermissions();
    }

    public function detachPermission( Permission $permission )
    {
        unset( $this->permissions );
        unset( $permission->roles );
        unset( $permission->users );
        $this->permissions()->detach( $permission->id );
        $this->rebuildUsersPermissions();
    }

    public function attachUser( Model $user )
    {
        unset( $this->users );
        $this->users()->sync( [ $user->id ], false );
        $user->rebuildPermissions();
    }

    public function detachUser( Model $user )
    {
        unset( $this->users );
        $this->users()->detach( $user->id );
        $user->rebuildPermissions();
    }

    public function rebuildUsersPermissions()
    {
        $this->users()->get()->each( function ( Model $user ) {
            $user->rebuildPermissions();
        } );
    }

    public function scopeHasLabel( Builder $builder, $label )
    {
        $builder->where( 'label', $label );
        return $builder;
    }

    public function scopeOrdered( Builder $builder )
    {
        $builder->orderBy( 'description' );
        return $builder;
    }


}
