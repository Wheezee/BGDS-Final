@extends('layouts.app')

@section('title', 'User Profile')

@section('header', 'User Profile')

@push('styles')
    <style>
    .profile-card {
        max-width: 800px;
        margin: 0 auto;
        }
        
    .form-section {
        margin-bottom: 2rem;
        }

    .form-section-title {
            color: var(--dark-purple);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-purple);
        }
        
    .required-field::after {
        content: '*';
        color: red;
        margin-left: 4px;
        }

    [data-theme="dark"] .text-muted {
        color: #bdbdbd !important;
    }
    </style>
@endpush

@section('content')
                <div class="row">
                    <div class="col-md-8 mx-auto">
        <div class="card profile-card">
                            <div class="card-header">
                                <h5 class="mb-0">Edit Profile</h5>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                
                                <form method="POST" action="{{ route('user.update') }}">
                                    @csrf
                                    @method('PUT')
                                    
                    <div class="form-section">
                        <h5 class="form-section-title">Basic Information</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                <label for="name" class="form-label required-field">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                <label for="email" class="form-label required-field">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                            </div>
                                        </div>
                                    </div>
                                    
                    <div class="form-section">
                        <h5 class="form-section-title">Change Password</h5>
                                    <p class="text-muted small">Leave these fields blank if you don't want to change your password.</p>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="current_password" class="form-label">Current Password</label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <a href="/dashboard" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
@endsection

@push('scripts')
    <script>
    // Add any page-specific JavaScript here
    </script>
@endpush 