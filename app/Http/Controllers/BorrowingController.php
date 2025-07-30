<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class BorrowingController extends Controller
{
    // Definisi status peminjaman yang diizinkan
    private const STATUSES = [
        'borrowed', 'returned', 'overdue', 'cancelled',
    ];

    /**
     * Display a listing of the borrowing transactions for the authenticated organization.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $organizationId = $user->organization_id;

        if (!$organizationId && !$user->isSuperAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke transaksi peminjaman.');
        }

        $query = Borrowing::query();

        if ($user->isOrganizationAdmin()) {
            $query->where('organization_id', $organizationId);
        }

        // Filter berdasarkan status
        if ($request->filled('filter_status') && in_array($request->input('filter_status'), self::STATUSES)) {
            $query->where('status', $request->input('filter_status'));
        } else {
            // Default: tampilkan yang masih dipinjam (borrowed) dan overdue
            $query->whereIn('status', ['borrowed', 'overdue']);
        }

        // Filter berdasarkan nama peminjam atau nama barang
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('borrower_name', 'like', '%' . $search . '%')
                  ->orWhereHas('inventoryItem', function ($itemQuery) use ($search) {
                      $itemQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $borrowings = $query->latest('borrow_date')->paginate(10)->withQueryString();
        $statuses = self::STATUSES;

        return view('borrowings.index', compact('borrowings', 'statuses'));
    }

    /**
     * Show the form for creating a new borrowing transaction.
     */
    public function create()
    {
        $user = Auth::user();
        $organizationId = $user->organization_id;

        if (!$organizationId && !$user->isSuperAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak dapat membuat transaksi peminjaman tanpa organisasi yang terkait.');
        }

        $inventoryItems = InventoryItem::where('organization_id', $organizationId)->get();

        return view('borrowings.create', compact('inventoryItems'));
    }

    /**
     * Store a newly created borrowing transaction in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $organizationId = $user->organization_id;

        if (!$organizationId) {
            return redirect()->back()->with('error', 'Anda tidak dapat membuat transaksi peminjaman tanpa organisasi yang terkait.');
        }

        $validatedData = $request->validate([
            'inventory_item_id' => [
                'required',
                'exists:inventory_items,id',
                Rule::exists('inventory_items', 'id')->where(function ($query) use ($organizationId) {
                    return $query->where('organization_id', $organizationId);
                }),
            ],
            'borrower_name' => ['required', 'string', 'max:255'],
            'borrower_contact' => ['nullable', 'string', 'max:255'],
            'borrower_nim_nip' => ['nullable', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'borrow_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:borrow_date'],
            'borrow_photo' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $item = InventoryItem::find($validatedData['inventory_item_id']);
        if ($item->quantity == 1 && $item->isBorrowed()) {
            return redirect()->back()->withInput()->with('error', 'Barang ini sedang dipinjam dan tidak dapat dipinjam lagi.');
        }

        Borrowing::create(array_merge($validatedData, [
            'organization_id' => $organizationId,
            'status' => 'borrowed',
            'borrowed_by' => Auth::id(),
        ]));

        return redirect()->route('borrowings.index')->with('success', 'Transaksi peminjaman berhasil dicatat!');
    }

    /**
     * Display the specified borrowing transaction.
     */
    public function show(Borrowing $borrowing)
    {
        if ($borrowing->organization_id !== Auth::user()->organization_id && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Show the form for editing (returning) the specified borrowing transaction.
     */
    public function edit(Borrowing $borrowing)
    {
        if ($borrowing->organization_id !== Auth::user()->organization_id && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        if (!in_array($borrowing->status, ['borrowed', 'overdue'])) {
            return redirect()->route('borrowings.show', $borrowing->id)->with('error', 'Transaksi ini tidak dapat diedit karena sudah ' . $borrowing->status . '.');
        }

        return view('borrowings.edit', compact('borrowing'));
    }

    /**
     * Update the specified borrowing transaction in storage (primarily for returning).
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->organization_id !== Auth::user()->organization_id && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($borrowing->status, ['borrowed', 'overdue'])) {
            return redirect()->back()->with('error', 'Transaksi ini tidak dapat diperbarui karena sudah ' . $borrowing->status . '.');
        }

        $validatedData = $request->validate([
            'return_date' => ['required', 'date', 'after_or_equal:borrow_date'],
            'return_photo' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $borrowing->return_date = $validatedData['return_date'];
        $borrowing->return_photo = $validatedData['return_photo'];
        $borrowing->notes = $validatedData['notes'];
        $borrowing->returned_by = Auth::id();
        $borrowing->status = 'returned'; // Set status menjadi 'returned'

        if ($borrowing->due_date && Carbon::parse($borrowing->return_date)->greaterThan(Carbon::parse($borrowing->due_date))) {
             // Anda bisa menambahkan logika atau flag khusus untuk pengembalian terlambat di sini
        }

        $borrowing->save();

        return redirect()->route('borrowings.index')->with('success', 'Transaksi peminjaman berhasil diperbarui (dikembalikan)!');
    }

    /**
     * Remove the specified borrowing transaction from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        if ($borrowing->organization_id !== Auth::user()->organization_id && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($borrowing->status === 'returned') {
            return redirect()->back()->with('error', 'Transaksi yang sudah dikembalikan tidak dapat dihapus.');
        }

        $borrowing->delete();
        return redirect()->route('borrowings.index')->with('success', 'Transaksi peminjaman berhasil dihapus!');
    }

    /**
     * Method to update item status for background color in inventory list.
     * This is a helper, not a route.
     * It checks if an item is currently borrowed.
     *
     * @param \App\Models\InventoryItem $item
     * @return string CSS class
     */
    public static function getItemRowClass(InventoryItem $item)
    {
        $isBorrowed = $item->borrowings()
                           ->whereIn('status', ['borrowed', 'overdue'])
                           ->exists();

        return $isBorrowed ? 'bg-red-100' : 'bg-green-100';
    }

    /**
     * Display a listing of historical borrowing transactions (status 'returned').
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $organizationId = $user->organization_id;

        if (!$organizationId && !$user->isSuperAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke histori peminjaman.');
        }

        $query = Borrowing::query();

        if ($user->isOrganizationAdmin()) {
            $query->where('organization_id', $organizationId);
        }

        // Hanya tampilkan transaksi dengan status 'returned'
        $query->where('status', 'returned');

        // Filter berdasarkan nama peminjam atau nama barang
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('borrower_name', 'like', '%' . $search . '%')
                  ->orWhereHas('inventoryItem', function ($itemQuery) use ($search) {
                      $itemQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Urutkan berdasarkan tanggal pengembalian terbaru, lalu berdasarkan ID untuk memecah ikatan
        $borrowings = $query->latest('return_date')->latest('id')->paginate(10)->withQueryString(); // DIUBAH DI SINI

        return view('borrowings.history', compact('borrowings'));
    }
}