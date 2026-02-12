<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Wallet extends Model
{

    protected $table = 'user_wallet';
    protected $guarded = [];


    // static function creditOrder($transactionType = null, $total, $order)
    // { 
    //     if ($transactionType === 'debit') {
    //         $transactionComment = 'Wallet Debit';
    //         $credit = $total;
    //     } else {
    //         $transactionComment = 'Order Purchase';
    //         $credit = ($total * 0.01);
    //     }
    //     self::create([
    //         'user_id' => Auth::user()->id,
    //         'transaction_type' => $transactionType ?? 'credit',
    //         'transaction_status' => 'pending_payment',
    //         'transaction_order' => $order,
    //         'transaction_points' => $credit,
    //         'transaction_comment' => $transactionComment,
    //         'transaction_madeby' => Auth::user()->id,
    //         'expiry_date' => now()->addYear()
    //     ]);

    //     if(Auth::check()){

    //         $wallet_amount = Users::find(Auth::user()->id)->value('wallet_amount');
    //         Users::where('id',Auth::user()->id)->update([
    //             'wallet_amount' => $wallet_amount + $credit,
    //             'expiry_date' => now()->addYear(),
    //         ]);
    //     }


    // }
    public static function creditOrder($transactionType = null, $total, $orderId)
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        if ($transactionType === 'debit') {
            $amountToUse = $total;
            $remaining = $amountToUse;

            $credits = \App\Models\Web\CashbackCredit::where('user_id', $user->id)
                ->where('expires_at', '>', now())
                ->whereColumn('used_amount', '<', 'amount')
                ->orderBy('created_at')
                ->get();
                foreach ($credits as $credit) {
                if ($remaining <= 0) break;
                $available = $credit->amount - $credit->used_amount;
                if ($available <= 0) continue;

                $use = min($available, $remaining);
                $credit->used_amount += $use;
                $credit->save();
                
                $remaining -= $use;
            }
            if ($remaining > 0) {
                throw new \Exception('Insufficient cashback balance.');
            }

            self::create([
                'user_id' => $user->id,
                'transaction_type' => 'debit',
                'transaction_status' => 'completed',
                'transaction_order' => $orderId,
                'transaction_points' => $amountToUse,
                'transaction_comment' => 'Used wallet credit for order #' . $orderId,
                'transaction_madeby' => $user->id,
                'expiry_date' => null,
            ]);

            $user->wallet_amount -= $amountToUse;
            $user->save();
        } else {
            $cashback = round($total * 0.01, 2);
            $expiry = now()->addYear();

            self::create([
                'user_id' => $user->id,
                'transaction_type' => 'credit',
                'transaction_status' => 'pending_payment',
                'transaction_order' => $orderId,
                'transaction_points' => $cashback,
                'transaction_comment' => 'Cashback for order #' . $orderId,
                'transaction_madeby' => $user->id,
                'expiry_date' => $expiry,
            ]);

            \App\Models\Web\CashbackCredit::create([
                'user_id' => $user->id,
                'order_id' => $orderId,
                'amount' => $cashback,
                'used_amount' => 0,
                'expires_at' => $expiry,
            ]);


            $user->wallet_amount = (float) $user->wallet_amount + $cashback;
            $user->save();
        }
    }

    static function getCredit()
    {
        $total = 0;

        $data = self::where('user_id', Auth::id())->get();
        foreach ($data as $item) {
            $order = \App\Models\Core\Order::find($item->transaction_order);

            if ($order && $order->order_status === 'Delivered') {
                if ($item->transaction_type === "credit" && strtotime($item->expiry_date) > time()) {
                    $total += $item->transaction_points;
                }

                if ($item->transaction_type == 'debit') {
                    $total -= $item->transaction_points;
                    // code...
                }
                // dd($item);


            }
        }

        return (string) $total;
    }


    static function addRemainder($credit, $order)
    {

        self::create([

            'user_id' => Auth::user()->id,
            'transaction_type' => 'debit',
            'transaction_status' => 'pending_payment',
            'transaction_order' => $order,
            'transaction_points' => $credit,
            'transaction_comment' => 'Order Remainder',
            'transaction_madeby' => Auth::user()->id,
            'expiry_date' => now()->addYear()

        ]);
    }
}
