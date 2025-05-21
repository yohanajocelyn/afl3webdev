<?php

namespace App\Enums;

enum ApprovalStatus: string
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Rejected = 'rejected';
}