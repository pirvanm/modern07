<?php

namespace Modules\Proposals\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Enums\ProposalStatuses;
use Illuminate\Support\Facades\Auth;

use Modules\Proposals\Events\ProposalStatusUpdated;

class LogAndSendEmailProposalStatusUpdate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $message = '';

        switch ($event->proposal->status){
            case ProposalStatuses::APPROVAL_OP->value:
                $message = ':name aproved the proposal from the operational department.';
                break;
            case ProposalStatuses::REJECTION_OP->value:
                $message = ':name REJECTION the proposal from the operational deparment. Reason :'.$event->reason;
                break;

            case ProposalStatuses::APPROVAL_LG->value:
                $message = ':name approved the proposal the proposal from the legal deparment.';
                break;

            case ProposalStatuses::REJECTION_LG->value:
                $message = ':name REJECTION the proposal from the legal department. Reason: '.$event->reason;
                break;
            case ProposalStatuses::DOCS_MANAGER->value:
                $message = ':name uploaded the documents for legal department.';
                break;
            case ProposalStatuses::PROCESSING_LG->value:
                $message = ':name succesfully processed the proposal. The process of opening and agency was opened';
                break;

        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($event->proposal)
            ->event('event')
            ->log($message);
    }
}
