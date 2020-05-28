<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
   
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
