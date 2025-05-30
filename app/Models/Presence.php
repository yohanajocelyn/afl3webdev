<?php

namespace App\Models;

use App\Enums\ApprovalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'meet_id',
        'registration_id',
        'dateTime',
        'status',
        'proofUrl'
    ];

    protected $casts = [
        'status' => ApprovalStatus::class,
    ];

    public function meet(): BelongsTo
    {
        return $this->belongsTo(Meet::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public static function allData()
    {
        return Presence::all();
    }
}
