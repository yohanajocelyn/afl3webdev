<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workshop extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'startDate', 'endDate', 'description', 'price', 'imageURL', 'isOpen'];

    public function registrations():HasMany {
        return $this->hasMany(Registration::class, 'workshop_id');
    }

    public static function allData() {
        return Workshop::all();
    }
}
