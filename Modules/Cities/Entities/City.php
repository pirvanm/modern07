<?php

namespace Modules\Cities\Entities;

use Modules\Cities\Entities\County;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = [];


    protected $with = ['county', 'parent'];

    protected static function newFactory()
    {
        return \Modules\Cities\Database\factories\CityFactory::new();
    }

    public function parent()
    {
        return $this->belongsTo(City::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function scopeSearchByName($query, $name)
    {
        $query->where('name', 'like', "%$name%");
    }
}
