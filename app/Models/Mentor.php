<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentor extends Model
{
    protected $fillable = ['name'];

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class, 'mentor_id');
    }
}
