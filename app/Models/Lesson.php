<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'youtube_link', 
        'other_link', 
        'status', 
        'course_id' // Ensure course_id is also fillable
    ];
    
}
