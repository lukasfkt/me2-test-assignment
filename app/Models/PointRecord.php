<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointRecord extends Model
{
    use HasFactory;

    # Attributes to be filled
    protected $fillable = [
        'time',
        'latitude',
        'longitude',
        'selfie'
    ];

    # Table reference
    protected $table = 'point_records';
}
