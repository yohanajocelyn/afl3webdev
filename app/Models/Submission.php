<?php

namespace App\Models;

use App\Enums\ApprovalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'assignment_id',
        'title',
        'note',
        'url',
        'path',
        'status',
        'revisionNote'
    ];

    protected $casts = [
        'status' => ApprovalStatus::class,
    ];

    public function assignment():BelongsTo {
        return $this->belongsTo(Assignment::class);
    }
    
    public function registration():BelongsTo {
        return $this->belongsTo(Registration::class);
    }

    public static function allData() {
        return Submission::all();
    }
}
