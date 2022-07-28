<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public $table = 'categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'color',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'category_id', 'id');
    }
    public function customers()
    {
        return $this->belongsToMany(User::class,'category_customer','category_id','customer_id');
    }

    public function agents()
    {
        return $this->belongsToMany(User::class,'agent_category','category_id','agent_id');
    }
}
