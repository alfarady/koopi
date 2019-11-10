<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'status', 'final_total'];

    public function products() {
        return $this->hasMany(TransactionProduct::class);
    }
}
