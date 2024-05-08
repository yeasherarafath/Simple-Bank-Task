@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body bg-info text-center">
                                    <h2>Balance</h2>
                                    <h3>{{ $data['user']->balance }} BDT</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">All Transaction</div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Amount</th>
                                                    <th>Fee</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['transactions'] as $transaction)
                                                <tr>
                                                    <th>{{ $loop->iteration }}</th>
                                                    <th>{{ $transaction->user->name }}</th>
                                                    <th>{{ $transaction->user->email }}</th>
                                                    <th>{{ $transaction->amount }}</th>
                                                    <th>{{ $transaction->fee }}</th>
                                                    <th>{{ $transaction->date }}</th>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- {{ __('You are logged in!') }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
