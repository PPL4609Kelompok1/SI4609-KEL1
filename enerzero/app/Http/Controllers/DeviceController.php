<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $user = Auth::user();
            \Log::info('User data: ' . json_encode($user->toArray()));
            
            // Get devices using the relationship
            $devices = $user->devices;
            
            \Log::info('Devices count: ' . $devices->count());
            \Log::info('Devices data: ' . $devices->toJson());
            
            return view('devices.index', compact('devices'));
        } catch (\Exception $e) {
            \Log::error('Error in DeviceController@index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil data perangkat: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            \Log::info('Storing device for user: ' . json_encode($user->toArray()));

            $request->validate([
                'name' => 'required|string|max:255',
                'wattage' => 'required|integer|min:1',
                'category' => 'required|string|max:255'
            ]);

            $device = new Device([
                'name' => $request->name,
                'wattage' => $request->wattage,
                'category' => $request->category
            ]);

            $user->devices()->save($device);

            \Log::info('Device created successfully: ' . $device->toJson());

            return redirect()->route('devices.index')
                ->with('success', 'Perangkat berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Error in DeviceController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan perangkat: ' . $e->getMessage());
        }
    }

    public function edit(Device $device)
    {
        try {
            $user = Auth::user();
            $device = Device::where('id', $device->id)
                ->where('user_id', $user->id)
                ->first();

            if (!$device) {
                return redirect()->route('devices.index')
                    ->with('error', 'Perangkat tidak ditemukan atau Anda tidak memiliki akses untuk mengedit perangkat ini');
            }

            return view('devices.edit', compact('device'));
        } catch (\Exception $e) {
            \Log::error('Error in DeviceController@edit: ' . $e->getMessage());
            return redirect()->route('devices.index')
                ->with('error', 'Terjadi kesalahan saat mengakses halaman edit: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Device $device)
    {
        try {
            $user = Auth::user();
            $device = Device::where('id', $device->id)
                ->where('user_id', $user->id)
                ->first();

            if (!$device) {
                return redirect()->route('devices.index')
                    ->with('error', 'Perangkat tidak ditemukan atau Anda tidak memiliki akses untuk mengedit perangkat ini');
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'wattage' => 'required|integer|min:1',
                'category' => 'required|string|max:255'
            ]);

            $device->update([
                'name' => $request->name,
                'wattage' => $request->wattage,
                'category' => $request->category
            ]);

            return redirect()->route('devices.index')
                ->with('success', 'Perangkat berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error in DeviceController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui perangkat: ' . $e->getMessage());
        }
    }

    public function destroy(Device $device)
    {
        try {
            $user = Auth::user();
            $device = Device::where('id', $device->id)
                ->where('user_id', $user->id)
                ->first();

            if (!$device) {
                return redirect()->route('devices.index')
                    ->with('error', 'Perangkat tidak ditemukan atau Anda tidak memiliki akses untuk menghapus perangkat ini');
            }

            $device->delete();
            return redirect()->route('devices.index')
                ->with('success', 'Perangkat berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error in DeviceController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus perangkat: ' . $e->getMessage());
        }
    }
} 