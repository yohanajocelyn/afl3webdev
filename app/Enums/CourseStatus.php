<?php

namespace App\Enums;

enum CourseStatus: string
{
    case Assigned = 'assigned';
    case Finished = 'finished';
}