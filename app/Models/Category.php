<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class);
    }

    public function parentcategory(){
        return $this->belongsTo(Category::class,'parent_id')->withDefault('');
    }

}
