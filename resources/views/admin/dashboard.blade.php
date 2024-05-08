@extends('admin.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header border-primary ">
                    <div class="card-title">
                        Create User
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.store.user') }}">
                        @csrf
                    
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                        </div>
                    
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="account_type" class="form-label">Account Type</label>
                            <select id="account_type" class="form-select" name="account_type" required>
                                <option value="Individual">Individual</option>
                                <option value="Business">Business</option>
                            </select>
                        </div>
                    
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">All Users</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['users'] as $user)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>{{ $user->name }}</th>
                                    <th>{{ $user->email }}</th>
                                    <th>{{ $user->balance }}</th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection