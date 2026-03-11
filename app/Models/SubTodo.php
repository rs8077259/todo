<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class SubTodo extends Model
{
    use HasUlids;
    
    protected $fillable = [
        'work',
        'discription',
        'todo_id',
        'completed',
        'reminder',
        'serverReminder',
        'intimated'
    ];

    public function todo(){
        return $this->belongsTo(Todo::class);
    }
}
