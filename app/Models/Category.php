<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id'];

    // Parent-Child relationship (One-to-Many)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');  // Tegishli ota
}

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');  // Tegishli bolalar
    }

}
