@extends('layouts.app')

@section('title', 'Projects Overview')

@section('header', 'Projects Overview' . (request('type') ? ' - ' . request('type') . ' Projects' : ''))

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

        .progress {
            height: 25px;
        }

        .project-type-toggle {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .project-type-toggle .btn {
            flex: 1;
            padding: 10px;
            font-size: 1.1rem;
            border-radius: 10px;
        }

        .project-type-toggle .btn.active {
            background-color: var(--primary-purple);
            border-color: var(--primary-purple);
            color: white;
        }

        .project-type-toggle .btn:not(.active) {
            background-color: white;
            color: var(--primary-purple);
            border: 2px solid var(--primary-purple);
        }

        .project-type-toggle .btn:not(.active):hover {
            background-color: #f8f9fa;
        }
        
        .filter-badge {
            background-color: var(--primary-purple);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-left: 10px;
        }

        .table th {
            color: var(--dark-purple);
            font-weight: 600;
        }

        .table td {
            vertical-align: middle;
        }

        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .action-buttons .btn {
            padding: 5px 10px;
            margin: 0 2px;
        }

        .action-buttons .btn i {
            font-size: 1rem;
        }
    </style>
@endpush

@section('content')
            <div class="container-fluid mt-4">
                <!-- Project Type Toggle -->
                <div class="project-type-toggle">
                    <a href="{{ route('projects.index', ['type' => 'BDP']) }}" 
                       class="btn {{ request('type') == 'BDP' ? 'active' : '' }}">
                        <i class="bi bi-building"></i> BDP Projects (20%)
                    </a>
                    <a href="{{ route('projects.index', ['type' => 'Calamity']) }}" 
                       class="btn {{ request('type') == 'Calamity' ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i> Calamity Projects (5%)
                    </a>
                </div>

                <!-- Projects Table -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Ongoing Development Projects</h5>
                        <a href="{{ route('projects.create') }}" class="btn btn-light">
                            <i class="bi bi-plus-lg"></i> Add New Project
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Start Date</th>
                                        <th>Target End Date</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projects as $project)
                                        <tr>
                                            <td>{{ $project->project_name }}</td>
                                            <td>{{ $project->start_date->format('M d, Y') }}</td>
                                            <td>{{ $project->target_end_date->format('M d, Y') }}</td>
                                            <td>
                                                <span class="status-badge bg-{{ 
                                                    $project->status == 'Completed' ? 'success' : 
                                                    ($project->status == 'Ongoing' ? 'primary' : 
                                                    ($project->status == 'Delayed' ? 'warning' : 'secondary')) 
                                                }}">
                                                    {{ $project->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: {{ $project->progress }}%;" 
                                                         aria-valuenow="{{ $project->progress }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                        {{ $project->progress }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="action-buttons">
                                                <a href="{{ route('projects.show', $project) }}" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this project?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $projects->links() }}
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