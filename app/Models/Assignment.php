<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'workshop_id',
        'title',
        'date'
    ];

    public function workshop():BelongsTo {
        return $this->belongsTo(Workshop::class);
    }

    public function submissions():HasMany {
        return $this->hasMany(Submission::class, 'assignment_id');
    }

    public static function allData() {
        return Assignment::all();
    }
}
