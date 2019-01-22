<?php

namespace App\Models\User_;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * MySQL table name
     * @var string 
     */
    protected $table = 'user_payments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'plan_id', 'price', 'card_number', 'ccv', 'status'
    ];
    /**
     * @return object Return the user object.
     */
    public function user() {
        $this->belongsTo('App/Models/User');
    }
    /**
     * @return object Return the plan object.
     */
    public function plan() {
        $this->belongsTo('App/Models/Plan');
    }
}
