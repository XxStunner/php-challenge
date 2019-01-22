<?php

namespace App\Models\User_;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    /**
     * MySQL table name
     * @var string 
     */
    protected $table = 'user_phones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'phone'
    ];
    /**
     * @return object Return the user object.
     */
    public function user() {
        $this->belongsTo('App/Models/User');
    }
}
