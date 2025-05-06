<?php

namespace Backpack\CRUD\Tests\Config\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use CrudTrait;

    protected $table = 'roles';
    protected $fillable = ['name'];

    /**
     * Get the user for the account details.
     */
    public function user()
    {
        return $this->belongsToMany('Backpack\CRUD\Tests\config\Models\User', 'user_role');
    }

    public function getRoleNameAttribute()
    {
        return $this->name.'++';
    }

    public function identifiableAttribute()
    {
        return 'name';
    }
}
