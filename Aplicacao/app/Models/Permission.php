<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Permission extends Model
{
    use SoftDeletes;

    protected $table      = 'permissions';

    protected $fillable = [
        'label',
        'description',
    ];

    protected $casts = [
        'id'         => 'integer',
    ];

    protected $dates = [ 'deleted_at' ];

    public function roles()
    {
        return $this->belongsToMany( Role::class, 'permission_role' )->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany( User::class, 'permission_user' )->withTimestamps();
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
