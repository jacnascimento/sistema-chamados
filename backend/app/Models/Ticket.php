<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'created_by',
        'status',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
