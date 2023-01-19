<?php

namespace Modules\Proposals\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Address;
use App\Models\CustomActivity;
use Modules\Cities\Entities\City;
use Modules\Openings\Entities\Opening;
use App\Traits\TelerikGridFilters;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Proposal extends Model
{
    use HasFactory, TelerikGridFilters,LogsActivity;

    protected $guarded = [];

    protected $casts  = [
        'created_at' => 'date:Y-m-d H:i:s'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function opening()
    {
        return $this->hasOne(Opening::class, 'proposal_id');
    }


    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function owner()
    {
        return $this->hasOne(ProposalOwner::class);
    }

    public function space()
    {
        return $this->hasOne(ProposalSpace::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])->logOnlyDirty();
    }

    public function tapActivity(CustomActivity $customActivity, string $eventName)
    {
        $user = Auth::user();

        if ($eventName === 'created') {
            $customActivity->description = ":name created a new proposal.";
        } else if ($eventName === 'updated') {
            $customActivity->description = ":name updated the proposal.";
        }

    }

    public function rent()
    {
        return $this->hasOne(ProposalRent::class);
    }

    public function competition()
    {
        return $this->hasOne(ProposalCompetition::class);
    }
}
