<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Auth;
use Carbon\Carbon;
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

       
        $user_account_type = Auth::user()->account_type; 
        $today = Carbon::today();
        $amt=$request->amount;

        
        $fees = ($user_account_type === 'Individual') ? 0.00015 : 0.00025;
        // dd($fees);

        $auth_user=Auth::user();
        
        // check condition for individual
        if ($user_account_type === 'Individual') {
            $total_amount=Transaction::where('transaction_type','Withdrawal')->whereMonth('date',$today->month)->whereYear('date',$today->year)->sum('amount');
    
            if ($total_amount <= 5000) { //check 2nd condition
                $fees = 0;
                $fee = $amt * $fees;
            }
            elseif($today->isFriday()){ //check first condition
                $fees = 0;
                $fee = $amt * $fees;
            }
             else{ //check 3rd condition
                if($amt <= 1000){
                    $fees = 0;
                    $fee = $amt * $fees;
                }else{
                    $remaining=$amt-1000;
                    $fee = $remaining * $fees;
                }
             }
        } elseif ($user_account_type === 'Business') { //check condition for business
            $total_amount=Transaction::where('transaction_type','Withdrawal')->sum('amount');
            if ($total_amount > 50000) {
                $fees = 0.00015;
                $fee = $amt * $fees;
            }else{
                $fee = $amt * $fees;
            }
        }
        
        $finalAmount = $amt + $fee;
        
        if ($auth_user->balance < $finalAmount) {
            // dd($finalAmount);
            return redirect()->back()->withErrors('Not enough funds!');
        }
        // dd($finalAmount);
    
        
    
          $store=Transaction::create([
            'user_id'=>$auth_user->id,
            'amount' => $amt,
            'date' => now(),
            'transaction_type' => 'Withdrawal',
            'fee' => $fee,
        ]);
        if($store){

            // Deduct amount and save transaction
            $auth_user->balance -= $finalAmount;
            $auth_user->save();
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
