@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Show All Deposits') }}
                    <a href="{{route('create.deposit')}}" class="btn btn-primary float-end">Create Deposit</a>
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
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                          </tr>
                        </thead>
                        <tbody>

                          @forelse ( Auth::user()->userDeposit as $deposit)
                          <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{$deposit->created_at->format('H:i:s')}}</td>
                            <td>{{$deposit->date->format('dS F, Y')}}</td>
                            <td> {{ Auth::user()->name }}</td>
                            <td>{{$deposit->amount}}</td>
                          </tr>
                          @empty
                            
                          @endforelse
                          
                        </tbody>
                      </table>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
