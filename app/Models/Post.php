<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'company_id',
        'user_id',
        'image_filename'
    ];
    
     public function user()
    {

        return $this->belongsTo('App\Models\User');
        
    }
}
