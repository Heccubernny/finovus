<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    //
    protected $table = 'payment_gateways';
    protected $fillable = ['name', 'image_url', 'minumum_amount', 'maximum_amount', 'fixed_charge', 'percent_charge', 'public_key', 'secret_key', 'token', 'additional_key1', 'additional_key2', 'additional_key3', 'status'];

    public function deposit(){
        return $this->hasMany(Deposit::class, 'id', 'payment_gateway_id');
    }
}
