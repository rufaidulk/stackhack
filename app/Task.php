<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use SoftDeletes;
    
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;
    const STATUS_COMPLETED = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'due_date', 'label_id', 'status'
    ];

    /**
     * Create a new task model
     * @param  array $attributes
     * @return void  
     */
    public function createModel($attributes)
    {
        try
        {
            $this->fill($attributes);
            $this->user_id = Auth::id();
            $this->status = self::STATUS_ACTIVE;

            $this->save();
        }
        catch (Exception $e) { 
            throw $e;
        }
    }
    
    public function updateModel($attributes)
    {
        try
        {
            $this->fill($attributes);
            $this->user_id = Auth::id();

            $this->save();
        }
        catch (Exception $e) { 
            throw $e;
        }
    }
}
