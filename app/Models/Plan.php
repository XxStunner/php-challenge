<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price'
    ];
    /**
     * @return array Return a array of Payment objects.
     */
    public function payments() {
        return $this->hasMany('App\Models\User_\Payment');
    }
}
