@extends('layouts.app')

@section('title', 'User Details')

@section('header', 'User Details')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-purple: #6f42c1;
            --light-purple: #e9ecef;
            --dark-purple: #563d7c;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: var(--primary-purple);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }

        .info-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        
        .info-value {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        
        .role-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            background-color: var(--primary-purple) !important;
        }

        .btn-primary {
            background-color: var(--primary-purple);
            border-color: var(--primary-purple);
        }
        
        .btn-primary:hover {
            background-color: var(--dark-purple);
            border-color: var(--dark-purple);
        }
    </style>
@endpush

@section('content')
            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">User Information</h5>
                                <div>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="bi bi-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <p class="info-label">Name</p>
                                        <p class="info-value">{{ $user->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="info-label">Email</p>
                                        <p class="info-value">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <p class="info-label">Role</p>
                                        <span class="badge bg-primary role-badge">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="info-label">Phone Number</p>
                                        <p class="info-value">{{ $user->phone ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="info-label">Created At</p>
                                        <p class="info-value">{{ $user->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="info-label">Updated At</p>
                                        <p class="info-value">{{ $user->updated_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection 