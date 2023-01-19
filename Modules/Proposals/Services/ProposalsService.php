<?php

namespace Modules\Proposals\Services;

use App\Enums\ProposalStatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Openings\Entities\Opening;
use Modules\Proposals\Entities\Proposal;
use Modules\Proposals\Events\ProposalStatusUpdated;

class ProposalsService
{
    public function store(array $data)
    {
        $proposal = Auth::user()->proposals()->save(new Proposal([
            'city_id' => $data['city_id'],
            'note' => $data['note'],
        ]));


        // attach address
        if (isset($data['address']) && $this->proposalRequestHasAddress($data['address'])) {
            $proposal->address()->create($data['address']);
        }

        // attach owner
        if (isset($data['owner']) && $this->proposalRequestHasOwner($data['owner'])) {
            $proposal->owner()->create($data['owner']);
        }

        // attach space
        if (isset($data['space']) && $this->proposalRequestHasSpace($data['space'])) {
            // to be sure we overwrite null
            $data['space']['bathroom'] = $data['space']['bathroom'] ?? 0;

            $proposal->space()->create($data['space']);
        }

        //attach rent
        if (isset($data['rent']) && $this->proposalRequestHasRent($data['rent'])) {

            $data['rent']['payment_type'] = $data['rent']['payment_type'] ?: '';
            $proposal->rent()->create($data['rent']);
        }

        //attach competion

        if (isset($data['competitionItem']) && $this->proposalRequestHasCompetition($data['competitionItem'])) {
            $data['competitionItem']['name'] = $data['competitionItem']['name'] ?: '';
            $data['competition']['name'] = $data['competition']['name'] ?: '';
            $proposal->competition()->create($data['competitionItem']);
        }

    }

    public function update(array $data, Proposal $proposal)
    {
        $proposal->update(['note' => $data['note']]);

        // update address
        if (isset($data['address']) && $this->proposalRequestHasAddress($data['address'])) {
            if ($proposal->address) {
                $proposal->address()->first()->update($data['address']);
            } else {
                $proposal->address()->create($data['address']);
            }

        }

        // update/create owner
        if (isset($data['owner']) && $this->proposalRequestHasOwner($data['owner'])) {
            if ($proposal->owner) {
                $proposal->owner()->first()->update($data['owner']);
            } else {
                $proposal->owner()->create($data['owner']);
            }

        }

        // update/create space
        if (isset($data['space']) && $this->proposalRequestHasSpace($data['space'])) {
            // to be sure we overwrite null

            $data['space']['bathroom'] = $data['space']['bathroom'] ?? 0;
            if ($proposal->space) {
                $proposal->space()->first()->update($data['space']);
            } else {
                $proposal->space()->create($data['space']);
            }

        }

        //update/create space
        if (isset($data['rent']) && $this->proposalRequestHasRent($data['rent'])) {

            if ($proposal->rent) {
                $proposal->rent()->first()->update($data['rent']);
            } else {
                $proposal->rent()->create($data['rent']);
            }

        }

        //update/create competition
        if (isset($data['competitionItem']) && $this->proposalRequestHasCompetition($data['competitionItem'])) {
            $data['competitionItem']['name'] = $data['competitionItem']['name'] ?: '';
            if ($proposal->competition) {
                $proposal->competition()->first()->update($data['competitionItem']);
            } else {
                $proposal->competition()->create($data['competitionItem']);
            }
        }
    }

    protected function proposalRequestHasOwner(array $owner)
    {
        return $this->isArrayFilled($owner);
    }

    protected function proposalRequestHasAddress(array $address)
    {
        return $this->isArrayFilled($address);
    }

    protected function proposalRequestHasSpace(array $space)
    {
        return $this->isArrayFilled($space);
    }


    protected function proposalRequestHasRent(array $rent)
    {
        return $this->isArrayFilled($rent);
    }

    protected function proposalRequestHasCompetition(array $competition)
    {
        return $this->isArrayFilled($competition);
    }


    protected function isArrayFilled(array $data)
    {
        return !empty(array_filter($data, fn($item) => !is_null($item)));
    }


    public function updateStatus(Proposal $proposal, Request $request)
    {
        if ($this->canUpdateStatusOperational($proposal->status, $request->get('status'))) {
           $proposal->update(['status' => $request->get('status')]);
           event(new ProposalStatusUpdated($proposal, $request->get('reason')));
        }

        if ($this->canUpdateStatusLegal($proposal->status, $request->get('status'))) {
           $proposal->update(['status' => $request->get('status')]);
           event(new ProposalStatusUpdated($proposal, $request->get('reason')));
        }
    }

    public function procesStatus(Proposal $proposal)
    {
        if($proposal->status === ProposalStatuses::APPROVAL_OP->value) {
            $proposal->update(['status' => ProposalStatuses::DOCS_MANAGER->value]);

            if($proposal->status === ProposalStatuses::APPROVAL_OP->value) {
                $proposal->update(['status' => ProposalStatuses::DOCS_MANAGER->value]);

                event(new ProposalStatusUpdated($proposal));
            }
        }
    }

    protected function canUpdateStatusOperational(string $status, string $newStatus)
    {
        return $status === ProposalStatuses::NEW->value &&
            in_array($newStatus, [ProposalStatuses::APPROVAL_OP->value, ProposalStatuses::REJECTION_OP->value]);
    }

    protected function canUpdateStatusLegal(string $status, string $newStatus)
    {
        return $status === ProposalStatuses::DOCS_MANAGER->value &&
            in_array($newStatus, [ProposalStatuses::APPROVAL_LG->value, ProposalStatuses::REJECTION_LG->value]);
    }

    public function isRejectStatus(string $status)
    {
        return $status === ProposalStatuses::DOCS_MANAGER->value &&
            in_array($status, [ProposalStatuses::REJECTION_OP->value, ProposalStatuses::REJECTION_LG->value]);
    }

    public function updateMap(Proposal $proposal, $data)
    {
        $proposal->update(['map' => json_encode($data)]);

        activity()
            ->causedBy(\Auth::user())
            ->performedOn($proposal)
            ->event('event')
            ->log(":name has saved the exact map location ({$data['lat']}/{$data['lng']})");
    }

    public function getProposals(Request $request)
    {
        $body = json_decode($request->body, true);

        //grid filters
        $filterColumns = array_key_exists('filter', $body) ? $body['filter']['filters'] : [];
        $sort = array_key_exists('sort', $body) ? $body['sort'] : [];

        //deal with filters

        //heavy stuff , wip
        $proposals = Proposal::select([
            'proposals.id',
            'proposals.status',
            'proposals.created_at',
            'cities.name as city_name',
            'cities.id as city_id',
            'counties.name as county_name',
            'counties.id as county_id',
            'users.name as user_name'
        ])
            ->join('cities', 'cities.id', '=', 'proposals.city_id')
            ->join('counties', 'counties.id', '=', 'cities.county_id')
            ->join('users', 'users.id', '=', 'proposals.created_by')
            ->filters($filterColumns)
            ->sort($sort);;

        $proposals = $proposals->skip($body['skip'])->take($body['take'])->get();

        return $proposals;
    }
}
