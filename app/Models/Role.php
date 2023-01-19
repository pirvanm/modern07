<?php

namespace App\Models;

use App\Traits\TelerikGridFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use HasFactory,TelerikGridFilters;

    protected $guarded = [];
}
