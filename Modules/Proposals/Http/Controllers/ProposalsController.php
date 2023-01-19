<?php

namespace Modules\Proposals\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Support\Renderable;
use Modules\Proposals\Services\ProposalsService;
use Modules\Proposals\Http\Requests\ProposalRequest;
use Modules\Proposals\Transformers\ProposalResource;
use Modules\Proposals\Entities\Proposal;
use Modules\Proposals\Http\Requests\ProposalUpdateRequest;

class ProposalsController extends Controller
{
    protected ProposalsService $proposalsService;

    public function __construct(ProposalsService $proposalsService)
    {
        $this->proposalsService = $proposalsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {
        return inertia('proposals::pages.home-page');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('proposals::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ProposalRequest $proposalRequst)
    {
        $this->proposalsService->store($proposalRequst->validated());

        return Redirect::route('proposals.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Proposal $proposal)
    {
        $proposal = $proposal->load('address')
            ->load('owner')
            ->load('space')
            ->load('activities.causer', 'activities.children.causer')
            ->load('city')
            ->load('rent');

        return inertia('proposals::pages.show-page', ['proposal' => $proposal]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('proposals::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ProposalUpdateRequest $proposalUpdateRequest, Proposal $proposal)
    {
        $this->proposalsService->update($proposalUpdateRequest->validated(), $proposal);

        return Redirect::route('proposals.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Proposal $proposal)
    {
        Proposal::destroy($proposal->id);

        return Redirect::route('proposals.index');
    }

    public function updateMap(Proposal $proposal, Request $request)
    {
       $data  = $request->validate(['lat' => 'required', 'lng' => 'required']);

        $this->proposalsService->updateMap($proposal,$data);

        return Redirect::back();
    }

    public function updateStatus(Proposal $proposal, Request $request)
    {
        $request->validate([
            'status' => 'required',
            'reason' => $this-> proposalsService->isRejectStatus(($request->get('status'))) ? 'required' : 'nullable'
        ]);

        $this->proposalsService->updateStatus($proposal, $request);

        return Redirect::back();
    }

    public function processStatus(Proposal $proposal, Request $request)
    {
        $this->proposalsService->processStatus($proposal, $request);
    }


    public function getData(Request $request)
    {
        return ProposalResource::collection($this->proposalsService
            ->getProposals($request))->additional(['total' => Proposal::count()]);
    }
}
