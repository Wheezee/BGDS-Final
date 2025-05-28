@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard Overview')

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        @php
            $visibleCards = 1; // Resident count is always visible
            if(in_array(auth()->user()->role, ['superadmin', 'admin', 'barangay_chairman', 'barangay_secretary', 'barangay_treasurer'])) {
                $visibleCards++;
            }
            if(in_array(auth()->user()->role, ['superadmin', 'admin', 'barangay_chairman', 'barangay_secretary'])) {
                $visibleCards++;
            }
            if(auth()->user()->role === 'superadmin') {
                $visibleCards++;
            }
            $colClass = 'col-12 col-md-' . (12 / min(4, $visibleCards));
        @endphp
        <div class="{{ $colClass }} mb-3">
            <div class="stat-card">
                <i class="bi bi-people"></i>
                <h3>{{ $totalResidents }}</h3>
                <p>Total Residents</p>
            </div>
        </div>
        @if(in_array(auth()->user()->role, ['superadmin', 'admin', 'barangay_chairman', 'barangay_secretary', 'barangay_treasurer']))
        <div class="{{ $colClass }} mb-3">
            <div class="stat-card">
                <i class="bi bi-cash-coin"></i>
                <h3>₱{{ number_format($totalIncome, 2) }}</h3>
                <p>Total Income</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Resident Demographics</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.stopPropagation()">
                            <i class="bi bi-three-dots-vertical me-1"></i>Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/residents/create"><i class="bi bi-plus-circle me-2"></i>Add Resident</a></li>
                            <li><a class="dropdown-item" href="/residents"><i class="bi bi-list-ul me-2"></i>View All</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="demographicsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Civil Status Distribution</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.stopPropagation()">
                            <i class="bi bi-three-dots-vertical me-1"></i>Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/residents/create"><i class="bi bi-plus-circle me-2"></i>Add Resident</a></li>
                            <li><a class="dropdown-item" href="/residents"><i class="bi bi-list-ul me-2"></i>View All</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="civilStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Age Distribution Row -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Age Distribution</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.stopPropagation()">
                            <i class="bi bi-three-dots-vertical me-1"></i>Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/residents/create"><i class="bi bi-plus-circle me-2"></i>Add Resident</a></li>
                            <li><a class="dropdown-item" href="/residents"><i class="bi bi-list-ul me-2"></i>View All</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="ageDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @if(in_array(auth()->user()->role, ['superadmin', 'admin', 'barangay_chairman', 'barangay_secretary', 'barangay_treasurer']))
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Financial Overview</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.stopPropagation()">
                            <i class="bi bi-three-dots-vertical me-1"></i>Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/finance/create"><i class="bi bi-plus-circle me-2"></i>Add Transaction</a></li>
                            <li><a class="dropdown-item" href="/finance"><i class="bi bi-list-ul me-2"></i>View All</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="financialChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Demographics Chart
    const demographicsCtx = document.getElementById('demographicsChart').getContext('2d');
    new Chart(demographicsCtx, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [{{ $maleResidents }}, {{ $femaleResidents }}],
                backgroundColor: ['#4e73df', '#e74a3b'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Civil Status Chart
    const civilStatusCtx = document.getElementById('civilStatusChart').getContext('2d');
    new Chart(civilStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Single', 'Married', 'Widowed', 'Separated'],
            datasets: [{
                data: [
                    {{ $civilStatus['single'] }},
                    {{ $civilStatus['married'] }},
                    {{ $civilStatus['widowed'] }},
                    {{ $civilStatus['separated'] }}
                ],
                backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b', '#f6c23e'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Age Distribution Chart
    const ageDistributionCtx = document.getElementById('ageDistributionChart').getContext('2d');
    new Chart(ageDistributionCtx, {
        type: 'bar',
        data: {
            labels: ['0-17', '18-24', '25-34', '35-44', '45-54', '55-64', '65+'],
            datasets: [{
                label: 'Number of Residents',
                data: [
                    {{ $ageDistribution['0-17'] }},
                    {{ $ageDistribution['18-24'] }},
                    {{ $ageDistribution['25-34'] }},
                    {{ $ageDistribution['35-44'] }},
                    {{ $ageDistribution['45-54'] }},
                    {{ $ageDistribution['55-64'] }},
                    {{ $ageDistribution['65+'] }}
                ],
                backgroundColor: '#4e73df',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Financial Chart
    const financialCtx = document.getElementById('financialChart').getContext('2d');
    new Chart(financialCtx, {
        type: 'bar',
        data: {
            labels: ['Income', 'Expenses'],
            datasets: [{
                label: 'Amount',
                data: [{{ $totalIncome }}, {{ $totalExpenses }}],
                backgroundColor: ['#1cc88a', '#e74a3b'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
