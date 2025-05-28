@extends('layouts.app')

@section('title', 'Edit Project')

@section('header', 'Edit Project')

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
    </style>
@endpush

@section('content')
            <div class="container-fluid mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Project Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('projects.update', $project) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="project_name" class="form-label">Project Name</label>
                                    <input type="text" class="form-control @error('project_name') is-invalid @enderror" 
                                           id="project_name" name="project_name" value="{{ old('project_name', $project->project_name) }}" required>
                                    @error('project_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="project_type" class="form-label">Project Type</label>
                                    <select class="form-select @error('project_type') is-invalid @enderror" 
                                            id="project_type" name="project_type" required>
                                        <option value="">Select Type</option>
                                        <option value="BDP" {{ old('project_type', $project->project_type) == 'BDP' ? 'selected' : '' }}>BDP (20%)</option>
                                        <option value="Calamity" {{ old('project_type', $project->project_type) == 'Calamity' ? 'selected' : '' }}>Calamity (5%)</option>
                                    </select>
                                    @error('project_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="target_end_date" class="form-label">Target End Date</label>
                                    <input type="date" class="form-control @error('target_end_date') is-invalid @enderror" 
                                           id="target_end_date" name="target_end_date" value="{{ old('target_end_date', $project->target_end_date->format('Y-m-d')) }}" required>
                                    @error('target_end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Not Started" {{ old('status', $project->status) == 'Not Started' ? 'selected' : '' }}>Not Started</option>
                                        <option value="Ongoing" {{ old('status', $project->status) == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                        <option value="Delayed" {{ old('status', $project->status) == 'Delayed' ? 'selected' : '' }}>Delayed</option>
                                        <option value="Completed" {{ old('status', $project->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="progress" class="form-label">Progress (%)</label>
                                    <input type="number" class="form-control @error('progress') is-invalid @enderror" 
                                           id="progress" name="progress" value="{{ old('progress', $project->progress) }}" 
                                           min="0" max="100" required>
                                    @error('progress')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="assigned_committee" class="form-label">Assigned Committee</label>
                                    <input type="text" class="form-control @error('assigned_committee') is-invalid @enderror" 
                                           id="assigned_committee" name="assigned_committee" value="{{ old('assigned_committee', $project->assigned_committee) }}" required>
                                    @error('assigned_committee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description', $project->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('projects.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Project</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
@endsection 