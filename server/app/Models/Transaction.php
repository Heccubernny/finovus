<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = "transactions";
    protected $guarded = [];

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function invoiceLink(){
        return $this->belongsTo(Invoice::class, 'payment_link');
    }
    public function directLink(){
        return $this->belongsTo(PaymentLink::class, 'payment_link');
    }
}
