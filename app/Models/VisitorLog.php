<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class VisitorLog extends Model
{
    use HasFactory, Uuid;

    public $timestamps = false;

    protected $fillable = [
        'website_id',
        'ip_address',
        'user_agent',
        'referrer',
        'visited_at',
        'current_url'
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
