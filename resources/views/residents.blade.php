@extends('layouts.app')

@section('title', 'Residents')

@section('header')
    Resident Management
@endsection

@push('styles')
<style>
    .table-responsive {
        margin-top: 1rem;
    }
    
    .table th {
        white-space: nowrap;
    }
    
    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <h5 class="mb-2 mb-md-0">Resident List</h5>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="bi bi-file-earmark-arrow-up"></i> Import Residents
                    </button>
                    <a href="/residents-all-info" class="btn btn-light">Show All Information</a>
                    <a href="/add_resident" class="btn btn-light">Add New Resident</a>
                </div>
            </div>
            <div class="card-body">
                <!-- Search Bar -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search residents...">
                    </div>
                </div>
                <!-- Basic Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ route('residents.index', ['sort' => 'last_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark text-decoration-none">
                                        Name
                                        @if(request('sort') == 'last_name')
                                            <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('residents.index', ['sort' => 'place_of_birth', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark text-decoration-none">
                                        Address
                                        @if(request('sort') == 'place_of_birth')
                                            <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('residents.index', ['sort' => 'contact_number', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark text-decoration-none">
                                        Contact
                                        @if(request('sort') == 'contact_number')
                                            <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('residents.index', ['sort' => 'age', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark text-decoration-none">
                                        Age
                                        @if(request('sort') == 'age')
                                            <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($residents as $resident)
                            <tr>
                                <td>{{ $resident->full_name }}</td>
                                <td>{{ $resident->place_of_birth }}</td>
                                <td>{{ $resident->contact_number }}</td>
                                <td>{{ $resident->age }}</td>
                                <td>
                                    <a href="{{ route('residents.show', $resident->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('residents.edit', $resident->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('residents.destroy', $resident->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this resident?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Detailed Table (Collapsible) -->
                <div class="collapse mt-4" id="detailedTable">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Suffix</th>
                                    <th>Place of Birth</th>
                                    <th>Date of Birth</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Civil Status</th>
                                    <th>Citizenship</th>
                                    <th>Occupation</th>
                                    <th>Labor Status</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                    <th>Education</th>
                                    <th>Mother's Name</th>
                                    <th>Father's Name</th>
                                    <th>PhilSys Card #</th>
                                    <th>Household ID #</th>
                                    <th>Program Participation</th>
                                    <th>Family Group</th>
                                    <th>Blood Type</th>
                                    <th>Height</th>
                                    <th>Weight</th>
                                    <th>Skin Complexion</th>
                                    <th>Voter</th>
                                    <th>Resident Voter</th>
                                    <th>Year Last Voted</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($residents as $resident)
                                <tr>
                                    <td>{{ $resident->last_name ?? 'N/A' }}</td>
                                    <td>{{ $resident->first_name ?? 'N/A' }}</td>
                                    <td>{{ $resident->middle_name ?? 'N/A' }}</td>
                                    <td>{{ $resident->suffix ?? 'N/A' }}</td>
                                    <td>{{ $resident->place_of_birth ?? 'N/A' }}</td>
                                    <td>{{ $resident->date_of_birth ? $resident->date_of_birth->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $resident->age ?? 'N/A' }}</td>
                                    <td>{{ $resident->sex ?? 'N/A' }}</td>
                                    <td>{{ $resident->civil_status ?? 'N/A' }}</td>
                                    <td>{{ $resident->citizenship ?? 'N/A' }}</td>
                                    <td>{{ $resident->occupation ?? 'N/A' }}</td>
                                    <td>{{ $resident->labor_status ?? 'N/A' }}</td>
                                    <td>{{ $resident->contact_number ?? 'N/A' }}</td>
                                    <td>{{ $resident->email ?? 'N/A' }}</td>
                                    <td>{{ $resident->education ?? 'N/A' }}</td>
                                    <td>{{ $resident->mother_name ?? 'N/A' }}</td>
                                    <td>{{ $resident->father_name ?? 'N/A' }}</td>
                                    <td>{{ $resident->philsys_number ?? 'N/A' }}</td>
                                    <td>{{ $resident->household_id ?? 'N/A' }}</td>
                                    <td>{{ $resident->program_participation ?? 'N/A' }}</td>
                                    <td>{{ $resident->family_group ?? 'N/A' }}</td>
                                    <td>{{ $resident->blood_type ?? 'N/A' }}</td>
                                    <td>{{ is_null($resident->height) || $resident->height === '' ? 'N/A' : $resident->height }}</td>
                                    <td>{{ is_null($resident->weight) || $resident->weight === '' ? 'N/A' : $resident->weight }}</td>
                                    <td>{{ $resident->skin_complexion ?? 'N/A' }}</td>
                                    <td>{{ $resident->voter ?? 'N/A' }}</td>
                                    <td>{{ $resident->resident_voter ?? 'N/A' }}</td>
                                    <td>{{ $resident->year_last_voted ?? 'N/A' }}</td>
                                    <td>{{ $resident->created_at ? $resident->created_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                    <td>{{ $resident->updated_at ? $resident->updated_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
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

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Residents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="importForm" action="{{ route('residents.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="importFile" class="form-label">Choose Excel File</label>
                        <input type="file" class="form-control" id="importFile" name="import_file" accept=".xlsx, .xls" required>
                        <div class="form-text">Please upload an Excel file (.xlsx or .xls) with resident data. The first row should contain column headers.</div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="importButton">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const table = document.querySelector('.table');
        const rows = table.getElementsByTagName('tr');

        // Start from 1 to skip header row
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;

            // Check each cell in the row
            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                if (cell.textContent.toLowerCase().indexOf(searchText) > -1) {
                    found = true;
                    break;
                }
            }

            // Show/hide row based on search
            row.style.display = found ? '' : 'none';
        }
    });

    // Import form handling
    document.getElementById('importForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitButton = document.getElementById('importButton');
        const spinner = submitButton.querySelector('.spinner-border');
        const fileInput = document.getElementById('importFile');
        
        if (!fileInput.files.length) {
            alert('Please select a file to import.');
            return;
        }

        // Show loading state
        submitButton.disabled = true;
        spinner.classList.remove('d-none');
        
        // Create FormData and submit
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Import successful!');
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Import failed'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error during import: ' + error.message);
        })
        .finally(() => {
            // Reset loading state
            submitButton.disabled = false;
            spinner.classList.add('d-none');
        });
    });
</script>
@endpush
