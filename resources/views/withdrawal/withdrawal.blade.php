@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Show All Withdrawal') }}
                    <a href="{{route('create.withdrawal')}}" class="btn btn-primary float-end">Create Withdrawal</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                              {{ $error }}
                          </div>
                        @endforeach
                    @endif
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Time</th>
                            <th scope="col">Date</th>
                            <th scope="col">Fee</th>
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                          </tr>
                        </thead>
                        <tbody>

                          @forelse ( Auth::user()->userWithdrawal as $withdraw)
                          <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{$withdraw->created_at->format('H:i:s')}}</td>
                            <td>{{$withdraw->date->format('dS F, Y')}}</td>
                            <td>{{$withdraw->fee}}</td>
                            <td> {{ Auth::user()->name }}</td>
                            <td>{{$withdraw->amount}}</td>
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
