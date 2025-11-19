<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Website extends Model
{
    use HasFactory, Uuid;
    protected $fillable = [
        'name',
        'url',
        'slug',
        'tracking_method',
        'total_visit'
    ];

    public function tokens()
    {
        return $this->hasMany(TrackingToken::class);
    }

    public function logs()
    {
        return $this->hasMany(VisitorLog::class);
    }
}
