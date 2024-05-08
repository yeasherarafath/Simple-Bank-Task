<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //

    function depositIndex(){
        $data['transactions'] = Transaction::with('user')->deposit()->get();
        $data['users'] = User::all();
        return view('admin.user.deposit',compact('data'));
    }

    


    function depositStore(Request $request){
        
        try {
            $request->validate([
                'user' => 'required|exists:users,id',
                'amount' => 'required|numeric|min:1',
            ], );
            
            DB::beginTransaction();
            
            $user = User::with('transactions')->find($request->user);

            $user->balance += $request->amount;

            $trnx = new Transaction;
            $trnx->transaction_type = 'deposit';
            $trnx->amount = $request->amount;
            $trnx->user_id = $request->user;
            $trnx->date = now();
            $trnx->fee = 0;

            $trnx->save();


            $user->save();

            Toastr::success('Amount has been deposited');
            DB::commit();
            return back();
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            Toastr::error('Failed to make deposit');
            return back()->withInput();
        }
    }

    function withdrawIndex()
    {
        $data['transactions'] = Transaction::with('user')->withdraw()->get();
        $data['users'] = User::all();
        return view('admin.user.withdraw', compact('data'));
    }

    function withdrawStore(Request $request)
    {

        try {
            $request->validate([
                'user' => 'required|exists:users,id',
                'amount' => 'required|numeric|min:1',
            ], );

            $amount = $request->amount;

            $user = User::with('transactions')->find($request->user);


            $user_month_trx = Transaction::withdraw()
                        ->whereMonth('date', now()->format('m'))
                        ->whereYear('date', now()->format('Y'))->sum('amount');


            

            $trnx = new Transaction;
            $trnx->transaction_type = 'withdrawal';
            $trnx->amount = $amount;
            $trnx->user_id = $request->user;
            $trnx->date = now();

            

            if ($user->account_type == 'Individual') {
                // for Individual ac
                $trx_percent = 0.015;
                if(now()->format('N')==5){
                    $feeAmount = 0;
                }else{

                    if($amount >= 1000){
                        $feeAmount = $amount - 1000; 
                    }

                    $limit = 5000 - $user_month_trx - $feeAmount;

                    if(5000 > $user_month_trx){ 
                        
                        if($limit > 0){
                            $feeAmount = 0;
                        }else{
                            $feeAmount = $limit * -1;
                        }
                    }


                    $trnx->fee = self::calculatePercentage($feeAmount, $trx_percent);
                }
                

            } else {
                // for bussiness ac
                $trx_percent = 0.025;
                if ($amount > 50000) {
                    $intialFee = self::calculatePercentage(50000, $trx_percent);
                    $feeAmount = $amount - 50000;
                    $trnx->fee = $intialFee + self::calculatePercentage($feeAmount, 0.015);
                }else{
                    $trnx->fee = self::calculatePercentage(50000, $trx_percent);
                }
                
            }

            

            $user->balance -= ($amount - $trnx->fee);

            if(0 > $amount - $trnx->fee){
                Toastr::error('You do not have enough balance to withdraw');
                return back()->withInput();
            }
            $trnx->save();

            $user->save();

            Toastr::success('Amount has been withdrawn');
            return back();
        } catch (\Throwable $th) {
            throw $th;

            Toastr::error('Failed to withdraw');
            return back()->withInput();
        }
    }

    static function calculatePercentage($value, $percentage) {
        return ($value * $percentage) / 100;
    }
}
