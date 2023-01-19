<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CustomActivity extends Activity
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function parent() {
        return $this->belongsTo(CustomActivity::class,'parent_id');
    }

    public function children() {
        return $this->hasMany(CustomActivity::class,'parent_id');
    }

    public function userable() {
        return $this->morphTo();
    }
}
