@extends('layouts.app')

@section('title', 'Add New Project')

@section('header', 'Add New Project')

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

        .form-control:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-purple);
            border-color: var(--primary-purple);
        }

        .btn-primary:hover {
            background-color: var(--dark-purple);
            border-color: var(--dark-purple);
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
            content: " *";
            color: red;
        }
    </style>
@endpush

@section('content')
            <div class="container-fluid mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Project Details</h5>
                        <a href="{{ route('projects.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-left"></i> Back to Projects
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('projects.store') }}" method="POST">
                            @csrf
                            
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <!-- Basic Information Section -->
                            <div class="form-section">
                                <h4 class="form-section-title">Basic Information</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="project_name" class="form-label required-field">Project Name</label>
                                        <input type="text" class="form-control" id="project_name" name="project_name" value="{{ old('project_name') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="project_type" class="form-label required-field">Project Type</label>
                                        <select class="form-select" id="project_type" name="project_type" required>
                                            <option value="">Select Type</option>
                                            <option value="BDP" {{ old('project_type') == 'BDP' ? 'selected' : '' }}>BDP (20%)</option>
                                            <option value="Calamity" {{ old('project_type') == 'Calamity' ? 'selected' : '' }}>Calamity (5%)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline Section -->
                            <div class="form-section">
                                <h4 class="form-section-title">Timeline</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date" class="form-label required-field">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="target_end_date" class="form-label required-field">Target End Date</label>
                                        <input type="date" class="form-control" id="target_end_date" name="target_end_date" value="{{ old('target_end_date') }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Status and Progress Section -->
                            <div class="form-section">
                                <h4 class="form-section-title">Status and Progress</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label required-field">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="Not Started" {{ old('status') == 'Not Started' ? 'selected' : '' }}>Not Started</option>
                                            <option value="Ongoing" {{ old('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                            <option value="Delayed" {{ old('status') == 'Delayed' ? 'selected' : '' }}>Delayed</option>
                                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="progress" class="form-label required-field">Progress (%)</label>
                                        <input type="number" class="form-control" id="progress" name="progress" value="{{ old('progress', 0) }}" min="0" max="100" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information Section -->
                            <div class="form-section">
                                <h4 class="form-section-title">Additional Information</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="assigned_committee" class="form-label">Assigned Committee</label>
                                        <input type="text" class="form-control" id="assigned_committee" name="assigned_committee" value="{{ old('assigned_committee') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="budget" class="form-label">Budget</label>
                                        <input type="number" class="form-control" id="budget" name="budget" value="{{ old('budget') }}" step="0.01">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Save Project
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
@endsection

@push('scripts')
    <script>
    // Add any page-specific JavaScript here
    </script>
@endpush 