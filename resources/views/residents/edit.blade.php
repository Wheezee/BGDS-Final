@extends('layouts.app')

@section('title', 'Edit Resident')

@section('header')
    Edit Resident
@endsection

@push('styles')
<style>
    .form-section {
        margin-bottom: 2rem;
    }

    .form-section-title {
        color: var(--dark-purple);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-purple);
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Resident Information</h5>
                <a href="/residents" class="btn btn-light">Back to Residents</a>
            </div>
            <div class="card-body">
                <form action="{{ route('residents.update', $resident->id) }}" method="POST">
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
                    
                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <h4 class="form-section-title">Personal Information</h4>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $resident->last_name }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $resident->first_name }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $resident->middle_name }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="suffix" class="form-label">Suffix/Ext.</label>
                                <input type="text" class="form-control" id="suffix" name="suffix" value="{{ $resident->suffix }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="place_of_birth" class="form-label">Place of Birth</label>
                                <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ $resident->place_of_birth }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $resident->date_of_birth->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="sex" class="form-label">Sex</label>
                                <select class="form-select" id="sex" name="sex" required>
                                    <option value="">Select</option>
                                    <option value="Male" {{ $resident->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $resident->sex == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="civil_status" class="form-label">Civil Status</label>
                                <select class="form-select" id="civil_status" name="civil_status" required>
                                    <option value="">Select</option>
                                    <option value="Single" {{ $resident->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ $resident->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Widowed" {{ $resident->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                    <option value="Divorced" {{ $resident->civil_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="citizenship" class="form-label">Citizenship</label>
                                <input type="text" class="form-control" id="citizenship" name="citizenship" value="{{ $resident->citizenship }}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text" class="form-control" id="occupation" name="occupation" value="{{ $resident->occupation }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="labor_status" class="form-label">Labor Status</label>
                                <select class="form-select" id="labor_status" name="labor_status">
                                    <option value="">Select</option>
                                    <option value="Employed" {{ $resident->labor_status == 'Employed' ? 'selected' : '' }}>Employed</option>
                                    <option value="Unemployed" {{ $resident->labor_status == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                                    <option value="PWD" {{ $resident->labor_status == 'PWD' ? 'selected' : '' }}>PWD</option>
                                    <option value="OFW" {{ $resident->labor_status == 'OFW' ? 'selected' : '' }}>OFW</option>
                                    <option value="Solo Parent" {{ $resident->labor_status == 'Solo Parent' ? 'selected' : '' }}>Solo Parent</option>
                                    <option value="OSY" {{ $resident->labor_status == 'OSY' ? 'selected' : '' }}>OSY</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ $resident->contact_number }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $resident->email }}">
                            </div>
                        </div>
                    </div>

                    <!-- Family Information Section -->
                    <div class="form-section">
                        <h4 class="form-section-title">Family Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="mother_name" class="form-label">Mother's Name</label>
                                <input type="text" class="form-control" id="mother_name" name="mother_name" value="{{ $resident->mother_name }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="father_name" class="form-label">Father's Name</label>
                                <input type="text" class="form-control" id="father_name" name="father_name" value="{{ $resident->father_name }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="family_group" class="form-label">Family Group</label>
                                <input type="text" class="form-control" id="family_group" name="family_group" value="{{ $resident->family_group }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="household_id" class="form-label">Household ID</label>
                                <input type="text" class="form-control" id="household_id" name="household_id" value="{{ $resident->household_id }}">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="form-section">
                        <h4 class="form-section-title">Additional Information</h4>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="education" class="form-label">Education</label>
                                <select class="form-select" id="education" name="education">
                                    <option value="">Select</option>
                                    <option value="Elementary" {{ $resident->education == 'Elementary' ? 'selected' : '' }}>Elementary</option>
                                    <option value="High School" {{ $resident->education == 'High School' ? 'selected' : '' }}>High School</option>
                                    <option value="Vocational" {{ $resident->education == 'Vocational' ? 'selected' : '' }}>Vocational</option>
                                    <option value="College" {{ $resident->education == 'College' ? 'selected' : '' }}>College</option>
                                    <option value="Post Graduate" {{ $resident->education == 'Post Graduate' ? 'selected' : '' }}>Post Graduate</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="blood_type" class="form-label">Blood Type</label>
                                <select class="form-select" id="blood_type" name="blood_type">
                                    <option value="">Select</option>
                                    <option value="A+" {{ $resident->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ $resident->blood_type == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ $resident->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ $resident->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ $resident->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ $resident->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ $resident->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ $resident->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="height" class="form-label">Height</label>
                                <input type="text" class="form-control" id="height" name="height" value="{{ $resident->height }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="weight" class="form-label">Weight</label>
                                <input type="text" class="form-control" id="weight" name="weight" value="{{ $resident->weight }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="skin_complexion" class="form-label">Skin Complexion</label>
                                <input type="text" class="form-control" id="skin_complexion" name="skin_complexion" value="{{ $resident->skin_complexion }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="program_participation" class="form-label">Program Participation</label>
                                <select class="form-select" id="program_participation" name="program_participation">
                                    <option value="">Select</option>
                                    <option value="MCCT" {{ $resident->program_participation == 'MCCT' ? 'selected' : '' }}>MCCT</option>
                                    <option value="4PS" {{ $resident->program_participation == '4PS' ? 'selected' : '' }}>4PS</option>
                                    <option value="UCT" {{ $resident->program_participation == 'UCT' ? 'selected' : '' }}>UCT</option>
                                </select>
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
                                    <option value="Yes" {{ $resident->voter == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ $resident->voter == 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="resident_voter" class="form-label">Resident Voter</label>
                                <select class="form-select" id="resident_voter" name="resident_voter">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ $resident->resident_voter == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ $resident->resident_voter == 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="year_last_voted" class="form-label">Year Last Voted</label>
                                <input type="text" class="form-control" id="year_last_voted" name="year_last_voted" value="{{ $resident->year_last_voted }}">
                            </div>
                        </div>
                    </div>

                    <!-- Identification Numbers Section -->
                    <div class="form-section">
                        <h4 class="form-section-title">Identification Numbers</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="philsys_number" class="form-label">PhilSys Card Number</label>
                                <input type="text" class="form-control" id="philsys_number" name="philsys_number" value="{{ $resident->philsys_number }}">
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 