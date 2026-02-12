<?php

namespace App\Models\Web;
use Auth;

use Illuminate\Database\Eloquent\Model;

class CashbackCredit extends Model
{
    protected $table = 'cashback_credits';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'amount' => 'decimal:2',
        'used_amount' => 'decimal:2',
        'expires_at' => 'datetime',
    ];

    public static function getAvailableNew()
{
    if(Auth::check()){

        return self::where('user_id', Auth::user()->id)
        ->where('expires_at', '>', now())
        ->where('confirmed', 1)
        ->sum(\DB::raw('amount - used_amount'));
    }

}
// public static function getAvailableNew()
// {
//     // $totalAvailableCredits = 0;

//     // if (Auth::check()) {
//     //     $sessionCurrencyValue = round(session('currency_value'), 4);

//     //     // Fetch all valid, partially available credits
//     //     $credits = self::where('user_id', Auth::user()->id)
//     //         ->where('expires_at', '>', now())
//     //         ->where('confirmed', 1)
//     //         ->whereColumn('used_amount', '<', 'amount') // Only partially or fully unused
//     //         ->get();

//     //     foreach ($credits as $credit) {
//     //         $availableAmount = $credit->amount - $credit->used_amount;
//     //         if ($availableAmount <= 0) continue;

//     //         $convertedAmount = $availableAmount;

//     //         // Convert to session currency using order's currency rate if needed
//     //         if (!empty($credit->order_id)) {
//     //             $order = \App\Models\Web\Order::find($credit->order_id);

//     //             if ($order) {
//     //                 $orderCurrencyValue = round($order->currency_value, 4);

//     //                 if ($orderCurrencyValue > 0 && $orderCurrencyValue !== $sessionCurrencyValue) {
//     //                     $convertedAmount = $availableAmount * ($sessionCurrencyValue / $orderCurrencyValue);
//     //                 }
//     //             }
//     //         }

//     //         $totalAvailableCredits += $convertedAmount;
//     //     }
//     // }

//     // return round($totalAvailableCredits, 2);
// $totalEarned = 0;
// $totalRedeemed = 0;
//     $wallets = \App\Models\Web\Wallet::where('user_id', Auth::user()->id)
//     ->where('transaction_status', 'completed')
//     ->get();

// $sessionCurrencyValue = round(session('currency_value'), 4);
// foreach ($wallets as $wallet) {
//     $points = $wallet->transaction_points;

//     $order = $wallet->transaction_order ? \App\Models\Web\Order::find($wallet->transaction_order) : null;

//     if ($order) {
//         $orderCurrencyValue = round($order->currency_value, 4);

//         if ($orderCurrencyValue !== $sessionCurrencyValue && $orderCurrencyValue > 0) {
//             // Proper conversion to session currency
//             $points = $points * ($sessionCurrencyValue / $orderCurrencyValue);
//         }
//     }

//     if ($wallet->transaction_type === 'credit') {
//         $totalEarned += $points;
//     } elseif ($wallet->transaction_type === 'debit') {
//         $totalRedeemed += $points;
//     }
// }
//     $total = $totalEarned + $totalRedeemed;
//     $totalAvailableCredits = $total - $totalRedeemed;
//     return round($totalAvailableCredits, 2);

// }








}
