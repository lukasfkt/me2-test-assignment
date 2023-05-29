<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    # Attributes to be filled
    protected $fillable = [
        'name',
        'registration',
        'cpf',
        'schedule_id'
    ];

    # Relationship with the Schedule class
    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }
}
