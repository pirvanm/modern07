<?php

namespace Modules\Employees\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';

    protected $fillable = [];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeFactory::new();
    }
}
