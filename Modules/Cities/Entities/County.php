<?php

namespace Modules\Cities\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class County extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Cities\Database\factories\CountyFactory::new();
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
