<?php

namespace SamirEltabal\Authsystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;
    protected $fillable = ['service', 'service_id', 'user_id'];
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
