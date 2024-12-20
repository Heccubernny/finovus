<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $table = "invoices";
    protected $guarded = [];
    
    public function sender()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }   
}
