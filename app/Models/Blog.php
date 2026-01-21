<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded = ['id'];

    public function postedBy(){
        return $this->belongsTo(User::class,'posted_by')->withDefault('');
    }

}
