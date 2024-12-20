<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLink extends Model
{
    //
    protected $table = "payment_link";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    } 
}
