<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','admin_id','banner'
    ];
    public function user(){
        return $this->belongsTo(User::class,'admin_id');
    }
}
