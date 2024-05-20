<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelProducts extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'price', 'image', 'category_id', 'expired_at', 'modified_by'];
    protected $hidden = ['created_at', 'updated_at'];
}
