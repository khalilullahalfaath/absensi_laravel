@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ __('Resend Verification Email') }}
                </div>
                <div class="card-body">
                    <p>
                        This is the form to reset your password. Please enter your email for verification.
                    </p>
                    
                    <form method="POST" action="{{ route('forget.password.post') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Enter your email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Request Password Reset Link</button>
                        
                    </form>
                    <a href="{{ route('sessions') }}" class="btn btn-secondary mt-3">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
