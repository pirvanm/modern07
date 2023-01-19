<?php

namespace Modules\Proposals\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalRent extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Proposals\Database\factories\ProposalRentFactory::new();
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
