@extends('layouts.app')

@section('title', 'Edit Meeting')

@section('header', 'Edit Meeting')

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
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Edit Meeting Details</h5>
                                <a href="{{ route('meetings.show', $meeting) }}" class="btn btn-light">
                                    <i class="bi bi-arrow-left"></i> Back to Details
                                </a>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('meetings.update', $meeting) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

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
                                                <label for="date_time" class="form-label required-field">Date & Time</label>
                                                <input type="datetime-local" class="form-control" 
                                                       id="date_time" name="date_time" 
                                                       value="{{ old('date_time', is_array($meeting->date_time) ? '' : $meeting->date_time->format('Y-m-d\TH:i')) }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                                                <input type="number" class="form-control" 
                                                       id="duration_minutes" name="duration_minutes" 
                                                       value="{{ old('duration_minutes', $meeting->duration_minutes) }}" 
                                                       min="1" placeholder="Enter duration in minutes">
                                                <small class="form-text text-muted">Enter the expected duration of the meeting in minutes</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Agenda Section -->
                                    <div class="form-section">
                                        <h4 class="form-section-title">Agenda</h4>
                                        <div class="mb-3">
                                            <label for="agenda" class="form-label required-field">Meeting Agenda</label>
                                            <textarea class="form-control" 
                                                      id="agenda" name="agenda" rows="3" required>{{ old('agenda', is_array($meeting->agenda) ? '' : $meeting->agenda) }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Location Section -->
                                    <div class="form-section">
                                        <h4 class="form-section-title">Location</h4>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="venue" class="form-label required-field">Venue</label>
                                                <input type="text" class="form-control" 
                                                       id="venue" name="venue" 
                                                       value="{{ old('venue', is_array($meeting->venue) ? '' : $meeting->venue) }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="organizer" class="form-label required-field">Organizer</label>
                                                <input type="text" class="form-control" 
                                                       id="organizer" name="organizer" 
                                                       value="{{ old('organizer', is_array($meeting->organizer) ? '' : $meeting->organizer) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Information Section -->
                                    <div class="form-section">
                                        <h4 class="form-section-title">Additional Information</h4>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="attendees" class="form-label required-field">Attendees</label>
                                                <input type="text" class="form-control @error('attendees') is-invalid @enderror" 
                                                       id="attendees" name="attendees" 
                                                       value="{{ is_array($meeting->attendees) ? implode(', ', $meeting->attendees) : $meeting->attendees }}" required>
                                                <small class="form-text text-muted">Enter attendee names separated by commas</small>
                                                @error('attendees')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="mt-2">
                                                    <input type="text" class="form-control mb-2" id="attendeeSearch" placeholder="Search residents...">
                                                    <div class="resident-list attendee-list" style="height: 215px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.25rem; padding: 0.5rem;">
                                                        @foreach(App\Models\Resident::orderBy('last_name')->get() as $resident)
                                                            <div class="form-check">
                                                                <input class="form-check-input attendee-checkbox" type="checkbox" value="{{ $resident->getFullNameAttribute() }}" id="attendee{{ $resident->id }}">
                                                                <label class="form-check-label" for="attendee{{ $resident->id }}">{{ $resident->getFullNameAttribute() }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="absentees" class="form-label">Absentees</label>
                                                <input type="text" class="form-control @error('absentees') is-invalid @enderror" 
                                                       id="absentees" name="absentees" 
                                                       value="{{ is_array($meeting->absentees) ? implode(', ', $meeting->absentees) : $meeting->absentees }}">
                                                <small class="form-text text-muted">Enter absentee names separated by commas</small>
                                                @error('absentees')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="mt-2">
                                                    <input type="text" class="form-control mb-2" id="absenteeSearch" placeholder="Search residents...">
                                                    <div class="resident-list absentee-list" style="height: 215px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.25rem; padding: 0.5rem;">
                                                        @foreach(App\Models\Resident::orderBy('last_name')->get() as $resident)
                                                            <div class="form-check">
                                                                <input class="form-check-input absentee-checkbox" type="checkbox" value="{{ $resident->getFullNameAttribute() }}" id="absentee{{ $resident->id }}">
                                                                <label class="form-check-label" for="absentee{{ $resident->id }}">{{ $resident->getFullNameAttribute() }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="transcription" class="form-label">Transcription</label>
                                            <ul class="nav nav-tabs" id="transcriptionTabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="text-tab" data-bs-toggle="tab" data-bs-target="#text-content" type="button" role="tab" aria-controls="text-content" aria-selected="true">Text Input</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="file-tab" data-bs-toggle="tab" data-bs-target="#file-upload" type="button" role="tab" aria-controls="file-upload" aria-selected="false">File Upload</button>
                                                </li>
                                            </ul>
                                            <div class="tab-content mt-2" id="transcriptionTabContent">
                                                <div class="tab-pane fade show active" id="text-content" role="tabpanel" aria-labelledby="text-tab">
                                                    <textarea class="form-control" 
                                                        id="transcription" name="transcription" 
                                                        rows="5">{{ old('transcription', is_array($meeting->transcription) ? '' : $meeting->transcription) }}</textarea>
                                                </div>
                                                <div class="tab-pane fade" id="file-upload" role="tabpanel" aria-labelledby="file-tab">
                                                    <input type="file" class="form-control" id="transcriptionFile" name="transcription_file">
                                                    <small class="form-text text-muted">
                                                        Upload a text file, PDF, or image of the transcription. 
                                                        This will override any text entered in the text input tab.
                                                    </small>
                                                    @if($meeting->transcription_file_path)
                                                        <div class="mt-2">
                                                            <span class="text-info">Current file: {{ basename($meeting->transcription_file_path) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- File Attachments Section -->
                                    <div class="form-section">
                                        <h4 class="form-section-title">File Attachments</h4>
                                        
                                        @if($meeting->attachments && $meeting->attachments->count() > 0)
                                            <div class="mb-4">
                                                <h5>Current Attachments</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Filename</th>
                                                                <th>Type</th>
                                                                <th>Size</th>
                                                                <th>Description</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($meeting->attachments as $attachment)
                                                                <tr>
                                                                    <td>{{ $attachment->original_filename }}</td>
                                                                    <td>{{ $attachment->file_type_display }}</td>
                                                                    <td>{{ $attachment->formatted_size }}</td>
                                                                    <td>{{ $attachment->description ?? 'No description' }}</td>
                                                                    <td>
                                                                        <div class="btn-group btn-group-sm">
                                                                            <a href="{{ route('meeting-attachments.download', $attachment) }}" class="btn btn-info">
                                                                                <i class="bi bi-download"></i> Download
                                                                            </a>
                                                                            <form action="{{ route('meeting-attachments.destroy', $attachment) }}" method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this attachment?')">
                                                                                    <i class="bi bi-trash"></i> Delete
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label class="form-label">Add New Documents</label>
                                            <div class="file-upload-container">
                                                <div class="attachment-row mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6">
                                                            <input type="file" class="form-control" name="attachments[]">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="attachment_descriptions[]" placeholder="Description (optional)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="additional-attachments"></div>
                                                <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-attachment">
                                                    <i class="bi bi-plus-circle"></i> Add Another File
                                                </button>
                                            </div>
                                            <small class="form-text text-muted">
                                                You can upload multiple files (max 10MB each). Supported formats include PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save"></i> Update Meeting
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@push('scripts')
    <script>
        // Script for attendees and absentees checkboxes
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle checkbox changes and update textbox
            function setupCheckboxes(checkboxClass, textboxId) {
                const checkboxes = document.querySelectorAll('.' + checkboxClass);
                const textbox = document.getElementById(textboxId);
                
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        // Get current values as array
                        let currentValues = textbox.value ? textbox.value.split(',').map(item => item.trim()) : [];
                        
                        if (this.checked) {
                            // Add value if not already present
                            if (!currentValues.includes(this.value)) {
                                currentValues.push(this.value);
                            }
                        } else {
                            // Remove value if present
                            currentValues = currentValues.filter(item => item !== this.value);
                        }
                        
                        // Join values with commas and update textbox
                        textbox.value = currentValues.join(', ');
                    });
                });

                // Check the checkboxes based on initial textbox values
                if (textbox.value) {
                    const initialValues = textbox.value.split(',').map(item => item.trim());
                    checkboxes.forEach(checkbox => {
                        if (initialValues.includes(checkbox.value)) {
                            checkbox.checked = true;
                        }
                    });
                }
            }
            
            // Setup for both attendees and absentees
            setupCheckboxes('attendee-checkbox', 'attendees');
            setupCheckboxes('absentee-checkbox', 'absentees');

            // Function to handle search filtering
            function setupSearch(searchInputId, listClass) {
                const searchInput = document.getElementById(searchInputId);
                const residentItems = document.querySelectorAll('.' + listClass + ' .form-check');
                
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    
                    residentItems.forEach(item => {
                        const residentName = item.querySelector('label').textContent.toLowerCase();
                        if (residentName.includes(searchTerm)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
            
            // Setup search for both lists
            setupSearch('attendeeSearch', 'attendee-list');
            setupSearch('absenteeSearch', 'absentee-list');
            
            // File attachment functionality
            document.getElementById('add-attachment').addEventListener('click', function() {
                const container = document.getElementById('additional-attachments');
                const newRow = document.createElement('div');
                newRow.className = 'attachment-row mb-3';
                newRow.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="attachments[]">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="attachment_descriptions[]" placeholder="Description (optional)">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-attachment">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(newRow);
                
                // Add event listener to remove button
                newRow.querySelector('.remove-attachment').addEventListener('click', function() {
                    container.removeChild(newRow);
                });
            });
        });
    </script>
@endpush 