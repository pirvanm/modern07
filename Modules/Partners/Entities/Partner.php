<?php

namespace Modules\Partners\Entities;

use App\Models\User;
use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Partners\Database\factories\PartnerFactory;

class Partner extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['fullName'];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function getFullNameAttribute(): string
    {
        return  $this->fname . ' ' . $this->lname;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PartnerFactory::new();
    }
}
