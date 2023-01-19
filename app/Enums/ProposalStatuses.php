<?php

namespace App\Enums;

use App\Traits\EnumsToArray;

enum ProposalStatuses: string
{
    use EnumsToArray;
    case NEW = "new";
    case APPROVAL_OP  = "operational approval";
    case REJECTION_OP  = "operational rejection";
    case APPROVAL_LG  = "legal approval";
    case REJECTION_LG  = "legal rejection";
    case WITHDRAWN = "witdrawn";
    case PROCESSING_LG  = "legal processing";
    case DOCS_MANAGER = "manager documents";
}
