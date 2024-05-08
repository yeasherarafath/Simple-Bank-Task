@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="d-flex justify-content-between align-content-between ">
                                <div>All Deposits</div>
                                <div><a href="{{ route('admin.dashboard') }}">Back</a></div>
                            </div>
                        </div>
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
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header border-primary ">
                        <div class="card-title">
                            Make Deposit
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.deposit.store') }}">
                            @csrf
            
                            <div class="mb-3">
                                <label for="user" class="form-label">User</label>
                                <select name="user" id="user" class="form-control form-select">
                                    @foreach ($data['users'] as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input value="10" type="number" name="amount" class="form-control " min="1">
                            </div>
            
            
            
                            <button type="submit" class="btn btn-primary">Deposit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection