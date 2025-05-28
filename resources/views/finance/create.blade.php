@extends('layouts.app')

@section('header')
    Add Financial Record
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add Financial Record</h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('finance.store') }}">
                            @csrf
                            
                            <!-- Basic Information Section -->
                            <div class="form-section">
                                <h4 class="form-section-title">Basic Information</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="date" class="form-label required-field">Date</label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                               id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="transaction_type" class="form-label required-field">Transaction Type</label>
                                        <select class="form-select @error('transaction_type') is-invalid @enderror" 
                                                id="transaction_type" name="transaction_type" required>
                                            <option value="">Select Type</option>
                                            <option value="Income" {{ old('transaction_type') == 'Income' ? 'selected' : '' }}>Income</option>
                                            <option value="Expense" {{ old('transaction_type') == 'Expense' ? 'selected' : '' }}>Expense</option>
                                        </select>
                                        @error('transaction_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Amount and Category Section -->
                            <div class="form-section">
                                <h4 class="form-section-title">Amount and Category</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="amount" class="form-label required-field">Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" min="0.01" 
                                                   class="form-control @error('amount') is-invalid @enderror" 
                                                   id="amount" name="amount" value="{{ old('amount') }}" required>
                                        </div>
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="category" class="form-label required-field">Category</label>
                                        <select class="form-select @error('category') is-invalid @enderror" 
                                                id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="Barangay Funds" {{ old('category') == 'Barangay Funds' ? 'selected' : '' }}>Barangay Funds</option>
                                            <option value="Aid" {{ old('category') == 'Aid' ? 'selected' : '' }}>Aid</option>
                                            <option value="Health" {{ old('category') == 'Health' ? 'selected' : '' }}>Health</option>
                                            <option value="Infrastructure" {{ old('category') == 'Infrastructure' ? 'selected' : '' }}>Infrastructure</option>
                                            <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education</option>
                                            <option value="Security" {{ old('category') == 'Security' ? 'selected' : '' }}>Security</option>
                                            <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Details Section -->
                            <div class="form-section">
                                <h4 class="form-section-title">Transaction Details</h4>
                                <div class="mb-3">
                                    <label for="source_payee" class="form-label required-field" id="source_payee_label">Source / Payee</label>
                                    <input type="text" class="form-control @error('source_payee') is-invalid @enderror" 
                                           id="source_payee" name="source_payee" value="{{ old('source_payee') }}" required>
                                    @error('source_payee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description / Purpose</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reference_number" class="form-label">Reference Number (OR#, Voucher#, etc.)</label>
                                    <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                                           id="reference_number" name="reference_number" value="{{ old('reference_number') }}">
                                    @error('reference_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="text-end mt-3">
                                <div class="d-flex flex-column flex-md-row gap-2 justify-content-end">
                                <a href="{{ route('finance.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to List
                                </a>
                                <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Add Transaction
                                </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const transactionType = document.getElementById('transaction_type');
        const sourcePayeeLabel = document.getElementById('source_payee_label');
        
        transactionType.addEventListener('change', function() {
            if (this.value === 'Income') {
                sourcePayeeLabel.textContent = 'Source';
            } else if (this.value === 'Expense') {
                sourcePayeeLabel.textContent = 'Payee';
            }
        });
    });
</script> 