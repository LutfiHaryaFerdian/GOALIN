<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldCategory extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'description', 'is_active'];

    public function fields()
    {
        return $this->hasMany(Field::class, 'category_id');
    }
}
