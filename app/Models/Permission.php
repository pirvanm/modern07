<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\TelerikGridFilters;
class Permission extends SpatieRole
{
    use HasFactory,TelerikGridFilters;
    protected $table = 'permissions';
    protected $guarded = [];
}
