@extends('layouts.app')

@section('title', 'Add Resident')

@section('header', 'Add Resident')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Resident Information</h5>
                    <a href="/residents" class="btn btn-light">Back to Residents</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('residents.store') }}" method="POST">
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
                        
                        <!-- Personal Information Section -->
                        <div class="form-section">
                            <h4 class="form-section-title">Personal Information</h4>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="last_name" class="form-label required-field">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="first_name" class="form-label required-field">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="suffix" class="form-label">Suffix</label>
                                    <input type="text" class="form-control" id="suffix" name="suffix">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="place_of_birth" class="form-label required-field">Place of Birth</label>
                                    <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label required-field">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="sex" class="form-label required-field">Sex</label>
                                    <select class="form-select" id="sex" name="sex" required>
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="civil_status" class="form-label required-field">Civil Status</label>
                                    <select class="form-select" id="civil_status" name="civil_status" required>
                                        <option value="">Select</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced">Divorced</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="citizenship" class="form-label required-field">Citizenship</label>
                                    <input type="text" class="form-control" id="citizenship" name="citizenship" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="labor_status" class="form-label">Labor Status</label>
                                    <select class="form-select" id="labor_status" name="labor_status">
                                        <option value="">Select</option>
                                        <option value="Employed">Employed</option>
                                        <option value="Unemployed">Unemployed</option>
                                        <option value="PWD">PWD</option>
                                        <option value="OFW">OFW</option>
                                        <option value="Solo Parent">Solo Parent</option>
                                        <option value="OSY">OSY</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contact_number" class="form-label required-field">Contact Number</label>
                                    <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>
                        </div>

                        <!-- Family Information Section -->
                        <div class="form-section">
                            <h4 class="form-section-title">Family Information</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mother_name" class="form-label">Mother's Name</label>
                                    <input type="text" class="form-control" id="mother_name" name="mother_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="father_name" class="form-label">Father's Name</label>
                                    <input type="text" class="form-control" id="father_name" name="father_name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="family_group" class="form-label">Family Group</label>
                                    <input type="text" class="form-control" id="family_group" name="family_group">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="household_id" class="form-label">Household ID</label>
                                    <input type="text" class="form-control" id="household_id" name="household_id">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="form-section">
                            <h4 class="form-section-title">Additional Information</h4>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="education" class="form-label">Education</label>
                                    <input type="text" class="form-control" id="education" name="education">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="blood_type" class="form-label">Blood Type</label>
                                    <select class="form-select" id="blood_type" name="blood_type">
                                        <option value="">Select</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="height" class="form-label">Height (cm)</label>
                                    <input type="number" class="form-control" id="height" name="height">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="weight" class="form-label">Weight (kg)</label>
                                    <input type="number" class="form-control" id="weight" name="weight">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="skin_complexion" class="form-label">Skin Complexion</label>
                                    <input type="text" class="form-control" id="skin_complexion" name="skin_complexion">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="program_participation" class="form-label">Program Participation</label>
                                    <input type="text" class="form-control" id="program_participation" name="program_participation">
                                </div>
                            </div>
                        </div>

                        <!-- Voter Information Section -->
                        <div class="form-section">
                            <h4 class="form-section-title">Voter Information</h4>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="voter" class="form-label">Voter</label>
                                    <select class="form-select" id="voter" name="voter">
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="resident_voter" class="form-label">Resident Voter</label>
                                    <select class="form-select" id="resident_voter" name="resident_voter">
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="year_last_voted" class="form-label">Year Last Voted</label>
                                    <input type="number" class="form-control" id="year_last_voted" name="year_last_voted">
                                </div>
                            </div>
                        </div>

                        <!-- Identification Numbers Section -->
                        <div class="form-section">
                            <h4 class="form-section-title">Identification Numbers</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="philsys_number" class="form-label">PhilSys Card Number</label>
                                    <input type="text" class="form-control" id="philsys_number" name="philsys_number">
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Resident</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 