<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'name', 'description', 'original_price', 'discount_price',
        'installment', 'installment_1', 'installment_2', 'installment_3',
        'installment_4', 'installment_5', 'installment_6', 'start_date',
        'duration', 'image',
    ];

    public function payments()
{
    return $this->hasMany(Payment::class);
}

}
