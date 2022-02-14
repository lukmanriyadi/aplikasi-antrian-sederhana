<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function queue()
    {
        return $this->hasMany(Queue::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}