<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class TrackingToken extends Model
{
    use HasFactory, Uuid;
    protected $fillable = [
        'website_id',
        'token',
        'active'
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
