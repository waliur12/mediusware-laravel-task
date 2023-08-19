<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    // show all withdrawal amount
    public function index(){
        return view('withdrawal.withdrawal');
    }
    
    // show create form
    public function create(){
        return view('withdrawal.create');
    }

    // store new withdrawal
    public function store(Request $request){
        $validatedData = $request->validate([
            'amount' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        try {

        $store=Transaction::create([
            'user_id'=>Auth::user()->id,
            'amount' => $request->amount,
            'date' => now(),
            'transaction_type' => 'Withdrawal',
            'fee' => 0,
        ]);

        if($store){
            $user=Auth::user();

            $user->balance=$user->balance-$request->amount;

            $user->save();
        }


        DB::commit();
          
        return redirect()->route('show.withdrawal')->with('status','Withdrawal added successfully!');

        } catch (\Exception $e) {
            DB::rollback();
        
            // Handle the exception
           return redirect()->back()->withErrors('Something went wrong!');
        }

    }

    
}
