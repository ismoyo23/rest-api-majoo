<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Users extends Model
{

    protected $guard_name = 'web';
    use HasRoles;
}