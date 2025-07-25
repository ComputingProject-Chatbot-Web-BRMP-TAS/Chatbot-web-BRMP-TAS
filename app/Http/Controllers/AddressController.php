<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // Tampilkan semua alamat milik user
    public function index()
    {
        $addresses = Auth::user()->addresses()->get();
        return view('customer.addresses', compact('addresses'));
    }

    // Simpan alamat baru
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'nullable|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'note' => 'nullable|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
        ]);
        $isFirst = Auth::user()->addresses()->count() === 0;
        $address = Auth::user()->addresses()->create([
            'label' => $request->label,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_primary' => $isFirst,
            'note' => $request->note,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
        ]);
        // Redirect berdasarkan field redirect_to atau default ke addresses
        $redirectTo = $request->input('redirect_to', route('addresses'));
        return redirect($redirectTo);
    }

    // Hapus alamat
    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        $wasPrimary = $address->is_primary;
        $address->delete();
        // Jika yang dihapus adalah primary, set salah satu alamat lain user jadi primary
        if ($wasPrimary) {
            $next = Auth::user()->addresses()->first();
            if ($next) {
                $next->is_primary = true;
                $next->save();
            }
        }
        $redirectTo = request('redirect_to', url()->previous() ?? route('addresses'));
        return redirect($redirectTo)->with('success', 'Alamat berhasil dihapus.');
    }

    // Set alamat utama
    public function setPrimary(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        // Reset semua alamat user ke is_primary = false
        Auth::user()->addresses()->update(['is_primary' => false]);
        $address->is_primary = true;
        $address->save();
        return redirect()->route('addresses')->with('success', 'Alamat utama diperbarui.');
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'label' => 'nullable|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'note' => 'nullable|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
        ]);
        $address->update([
            'label' => $request->label,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'note' => $request->note,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
        ]);
        // Redirect berdasarkan field redirect_to atau default ke addresses
        $redirectTo = $request->input('redirect_to', route('addresses'));
        return redirect($redirectTo);
    }
}
