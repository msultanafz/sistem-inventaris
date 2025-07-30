<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\User;
use App\Models\InventoryItem;
use App\Models\Borrowing; // Import model Borrowing
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dashboardData = [];
        $dashboardTitle = 'Dashboard';

        if ($user->isSuperAdmin()) {
            $dashboardTitle = 'Dashboard Super Admin';
            $dashboardData['totalOrganizations'] = Organization::count();
            $dashboardData['totalAdmins'] = User::count();
            // Statistik global lainnya untuk Super Admin bisa ditambahkan di sini
        } elseif ($user->isOrganizationAdmin()) {
            $organization = $user->organization;
            
            if ($organization) {
                $dashboardTitle = 'Dashboard ' . $organization->name;
                $dashboardData['organizationName'] = $organization->name;
                $dashboardData['organizationCode'] = $organization->code;

                // Statistik ringkasan inventaris untuk organisasi ini
                $dashboardData['totalItems'] = InventoryItem::where('organization_id', $organization->id)->count();
                
                // Mengambil jumlah barang yang sedang dipinjam
                $dashboardData['borrowedItemsCount'] = Borrowing::where('organization_id', $organization->id)
                                                                ->whereIn('status', ['borrowed', 'overdue'])
                                                                ->count();
                
            } else {
                $dashboardTitle = 'Dashboard Admin Organisasi';
                $dashboardData['totalItems'] = 0;
                $dashboardData['borrowedItemsCount'] = 0;
            }
        } else {
            $dashboardTitle = 'Dashboard Pengguna';
            $dashboardData['message'] = 'Selamat datang di dashboard Anda.';
        }

        return view('dashboard', compact('dashboardData', 'dashboardTitle'));
    }
}