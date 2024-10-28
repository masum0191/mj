<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable =[
        "purchase_id", "user_id", "sale_id", "cash_register_id", "account_id","payment_receiver", "payment_reference", "amount", "used_points", "change", "paying_method", "payment_note","resive_user"
    ];

public function user()
{
    return $this->hasOne(User::class);
}
}
