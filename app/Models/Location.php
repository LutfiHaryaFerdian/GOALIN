<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'city', 'province', 'address', 'latitude', 'longitude', 'is_active'];

    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
