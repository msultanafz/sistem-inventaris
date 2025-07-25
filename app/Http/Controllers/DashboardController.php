<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization; // Pastikan ini ada
use App\Models\User; // Pastikan ini ada

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil total organisasi dari database
        $totalOrganizations = Organization::count();

        // Ambil total admin/user dari database
        $totalAdmins = User::count(); // Asumsi semua user adalah admin saat ini

        return view('dashboard', compact('totalOrganizations', 'totalAdmins'));
    }
}