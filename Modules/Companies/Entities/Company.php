<?php

namespace Modules\Companies\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cities\Entities\City;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Companies\Database\factories\CompanyFactory::new();
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeSearchByName($query, $name)
    {
        $query->where('name', 'like', "%$name%");
    }
}
