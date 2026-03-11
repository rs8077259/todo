<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Todo extends Model
{
    use HasUlids;
    protected $fillable = [
        'name',
        'user_id',
        'color',
    ];
    public $timestamps = false;
    public function subTodo(): HasMany
    {
        return $this->hasMany(SubTodo::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
