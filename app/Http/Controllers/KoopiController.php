<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Product;
use App\Transaction;
use App\TransactionProduct;

class KoopiController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    
    public function users()
    {
        return $this->respondArray($this->user);
    }

    public function products()
    {
        $products = Product::all();
        return $this->respondArray($products);
    }

    public function showProducts($id)
    {
        $products = Product::find($id);
        return $this->respondArray($products);
    }

    public function transactions()
    {
        $transactions = Transaction::all();
        return $this->respondArray($transactions);
    }

    public function showTransactions($id)
    {
        $transactions = Transaction::find($id);
        $transactions->products;
        return $this->respondArray($transactions);
    }

    public function doTransactions(Request $request)
    {
        $products = $request->input('products');
        $payment_method = $request->input('payment_method');

        $final_total = 0;
        foreach($products as $product) {
            $productData = Product::find($product['id']);
            $final_total += ($productData->price * $product['qty']);
        }

        if($payment_method == 'balance') {
            if($final_total > $this->user->balance){
                return $this->respondFailed("Saldo kamu tidak mencukupi");
            }
        }
        
        $transaction = Transaction::create([
            'user_id' => $this->user->id,
            'final_total' => $final_total
        ]);

        if(!$transaction) {
            return $this->respondFailed();
        }

        $newbalance = $this->user->balance - $final_total;
        $this->user->update(['balance' => $newbalance]);

        foreach($products as $product) {
            TransactionProduct::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product['id'],
                'quantity' => $product['qty']
            ]);
        }

        return $this->respondSuccess($transaction, "Order ditetapkan");

    }
}
