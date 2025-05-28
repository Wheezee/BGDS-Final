<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\FinancialRecord;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Resident Statistics
        $totalResidents = Resident::count();
        $maleResidents = Resident::where('sex', 'Male')->count();
        $femaleResidents = Resident::where('sex', 'Female')->count();

        // Calculate age distribution with meaningful categories
        $residents = Resident::whereNotNull('date_of_birth')->get();
        $ageDistribution = [
            '0-17' => 0,
            '18-24' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45-54' => 0,
            '55-64' => 0,
            '65+' => 0
        ];

        foreach ($residents as $resident) {
            if ($resident->date_of_birth) {
                $age = \Carbon\Carbon::parse($resident->date_of_birth)->age;
                
                if ($age <= 17) $ageDistribution['0-17']++;
                elseif ($age <= 24) $ageDistribution['18-24']++;
                elseif ($age <= 34) $ageDistribution['25-34']++;
                elseif ($age <= 44) $ageDistribution['35-44']++;
                elseif ($age <= 54) $ageDistribution['45-54']++;
                elseif ($age <= 64) $ageDistribution['55-64']++;
                else $ageDistribution['65+']++;
            }
        }

        // Calculate civil status distribution
        $civilStatus = [
            'single' => Resident::where('civil_status', 'Single')->count(),
            'married' => Resident::where('civil_status', 'Married')->count(),
            'widowed' => Resident::where('civil_status', 'Widowed')->count(),
            'separated' => Resident::where('civil_status', 'Separated')->count()
        ];

        // Financial Statistics
        $totalIncome = FinancialRecord::where('transaction_type', 'Income')->sum('amount');
        $totalExpenses = FinancialRecord::where('transaction_type', 'Expense')->sum('amount');

        // Meeting Statistics
        $totalMeetings = Meeting::count();
        $recentMeetings = Meeting::latest()->take(5)->get();

        // User Statistics
        $totalUsers = User::count();

        // Recent Financial Transactions
        $recentTransactions = FinancialRecord::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalResidents',
            'maleResidents',
            'femaleResidents',
            'totalIncome',
            'totalExpenses',
            'totalMeetings',
            'recentMeetings',
            'totalUsers',
            'recentTransactions',
            'civilStatus',
            'ageDistribution'
        ));
    }
} 