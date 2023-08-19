@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Show All Withdrawal') }}
                    <h4  class="float-end text-warning">Current Balance: {{ Auth::user()->balance }}</h4>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Time</th>
                            <th scope="col">Date</th>
                            <th scope="col">Transaction Type</th>
                            <th scope="col">Transaction Fee</th>
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                          </tr>
                        </thead>
                        <tbody>

                          @forelse ( Auth::user()->userTransaction as $transaction)
                          <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{$transaction->created_at->format('H:i:s')}}</td>
                            <td>{{$transaction->date->format('dS F, Y')}}</td>
                            <td> {{$transaction->transaction_type }}</td>
                            <td> {{$transaction->fee }}</td>
                            <td> {{ Auth::user()->name }}</td>
                            <td>{{$transaction->amount}}</td>
                          </tr>
                          @empty
                          <tr>
                            
                            <td colspan="7">No transaction</td>
                          </tr>
                          @endforelse
                          
                        </tbody>
                      </table>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
