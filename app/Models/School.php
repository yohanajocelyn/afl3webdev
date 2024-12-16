<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'city'];

    public function teachers():HasMany {
        return $this->hasMany(Teacher::class, 'school_id');
    }

    public static function allData() {
        return School::all();
    }

    public static function dataWithid($id){
        return School::find($id);
    }
}
