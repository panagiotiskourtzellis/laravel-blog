<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Table name
    protected $table = 'posts';

    //Primary key
    public $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Post - Comment relation
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }
    
}