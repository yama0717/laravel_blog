<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable =['user_id', 'title', 'body', 'image'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
 
    public function likedUsers(){
        return $this->belongsToMany(User::class, 'likes');
    }
    public function isLikedBy($user){
        $liked_users_ids = $this->likedUsers->pluck('id');
        $result = $liked_users_ids->contains($user->id);
        return $result;
    }
    
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
