<?php

namespace Modules\Proposals\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CustomActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class ProposalSpace extends Model
{
    use HasFactory,LogsActivity;

    protected $guarded = [];



    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    public function tapAcitivity(CustomActivity $customActivity, string $eventName) : void {
        $customActivity->parent()->associate($this->proposal->activities()->latest()->first());

        $user = Auth::user();

        if($eventName === 'created') {
            $customActivity->description = ":name added the space.";
        } else if($eventName === 'updated') {
            $customActivity->description = ":name updated the space";
        }
    }
}
