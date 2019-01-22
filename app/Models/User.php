<?php

namespace App\Models;

use App\Models\User_\Phone;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'doc', 'address_street', 'address_complement', 'address_neighborhood', 'address_city', 'address_state'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
    /**
     * Insert the user in the database with the phones provided.
     * @param array $user - The user multidimensional array.
     * @return int The new user id.
     */
    public static function createWithPhones($user) {
        $id = User::insertGetId([
            'name' => $user["name"],
            'email' => $user["email"],
            'doc' => $user["doc"],
            "address_street" => $user["address_street"],
            "address_complement" => $user["address_complement"],
            "address_neighborhood" => $user["address_neighborhood"],
            "address_city" => $user["address_city"],
            "address_state" => $user["address_state"]
        ]);
        
        foreach($user["phones"] as &$phone) {
            Phone::create([
                'user_id' =>  $id,
                'phone' => $phone
            ]);
        }

        return $id;
    }
    /**
     * @return array Return a array of Payment objects.
     */
    public function payments() {
        return $this->hasMany('App\Models\User_\Payment');
    }
    /**
     * @return array Return a array of Phone objects.
     */
    public function phones() {
        return $this->hasMany('App\Models\User_\Phone');
    }
}
