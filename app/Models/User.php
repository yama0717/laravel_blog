<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    // リレーションを設定
    public function posts(){
        return $this->hasMany(Post::class);
    }
    
    public function follows(){
        return $this->hasMany(Follow::class);
    }
    
    public function follow_users(){
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id');
    }
    
    public function followers(){
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id');
    }
    
    // おすすめユーザー
    public function scopeRecommend($query, $self_id){
        // return $query->where('id', '!=', $self_id)->latest()->limit(3);
        return $query->where('id' , '!=' , $self_id)->inRandomOrder()->limit(3);
    }
    
    // フォロー確認
    public function isFollowing($user){
        $result = $this->follow_users->pluck('id')->contains($user->id);
        return $result;
    }
}
