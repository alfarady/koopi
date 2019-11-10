<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionProduct extends Model
{
    protected $fillable = ['transaction_id', 'product_id', 'quantity'];
}
