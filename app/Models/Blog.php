<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Laravel\Sanctum\Contracts\HasApiTokens;
use Laravel\Sanctum\HasApiTokens;

class Blog extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $table='blogs';
    protected $fillable = [
        'user_id','title','content'
    ];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
