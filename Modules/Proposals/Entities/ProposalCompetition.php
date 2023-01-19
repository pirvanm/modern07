<?php

namespace Modules\Proposals\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CustomActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class ProposalCompetition extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'proposal_competitions';

    protected $guarded = [];

    protected static $recordEvents = ['created', 'updated'];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])->logOnlyDirty();
    }

    public function tapActivity(CustomActivity $customActivity,string $eventName){
        $customActivity->parent()->associate($this->proposal->activities()->latest()->first());

        $user = Auth::user();

        if ($eventName === 'created') {
            $customActivity->description = ":name added the owner.";
        } else if ($eventName === 'updated') {
            $customActivity->description = ":name updated the owner.";
        }
    }
}
