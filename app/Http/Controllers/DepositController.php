<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Auth;
use Illuminate\Support\Facades\DB;
class DepositController extends Controller
{
    
    // show all deposit amount
    public function index(){
        return view('deposit.show_deposit');
    }
    
    // show create form
    public function create(){
        return view('deposit.create');
    }
    
    // store new deposit
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
            'transaction_type' => 'Deposit',
            'fee' => 0,
        ]);

        if($store){
            $user=Auth::user();

            $user->balance=$user->balance+$request->amount;

            $user->save();
        }


        DB::commit();
          
        return redirect()->route('show.deposit')->with('status','Deposit added successfully!');

        } catch (\Exception $e) {
            DB::rollback();
        
            // Handle the exception
           return redirect()->back()->withErrors('Something went wrong!');
        }

        

    }
}
