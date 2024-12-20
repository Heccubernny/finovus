<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    //
    protected $table = 'deposits';
    protected $guarded = [];

    public function paymentGatway(){
        $this->belongs(PaymentGateway::class, 'payment_gateway_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
