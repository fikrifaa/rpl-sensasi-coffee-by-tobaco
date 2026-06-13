<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reservation::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('customer_name', 'like', '%' . $search . '%')
                  ->orWhere('reservation_code', 'like', '%' . $search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $search . '%');
        }

        $reservations = $query->latest()->paginate(5);
        return view('pages.reservation.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        return view('pages.reservation.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Request data:', $request->all());

            $validatedData = $request->validate([
                'customer_name'    => 'required|string|max:255',
                'customer_phone'   => 'required|string|max:15',
                'notes'            => 'nullable|string',
                'table_number'     => 'required|string|max:50', 
                'reservation_date' => 'required|date',
                'reservation_time' => 'required',
            ]);

            // LOGIKA ANTI-BENTROK: Cek apakah meja sudah dipesan di tanggal yang sama
            $isTableBooked = Reservation::where('table_number', $request->table_number)
                ->where('reservation_date', $request->reservation_date)
                ->whereIn('status', ['pending', 'confirmed', 'seated']) 
                ->exists();

            if ($isTableBooked) {
                return redirect()->back()
                    ->with('error', "Gagal! " . $request->table_number . " sudah dipesan untuk tanggal " . date('d-m-Y', strtotime($request->reservation_date)) . ". Silakan pilih meja atau tanggal lain.")
                    ->withInput();
            }

            $reservationCode = $this->generateReservationCode();

            $reservation = new Reservation($validatedData);
            $reservation->reservation_code = $reservationCode;
            
            // Pengaman status awal create ke 'pending' jika form melempar nilai 'booked'
            $incomingStatus = $request->status ?? 'pending';
            $reservation->status = ($incomingStatus == 'booked') ? 'pending' : $incomingStatus;

            $reservation->save();

            return redirect()->route('reservation.index')->with('success', 'Reservation successfully created');
        } catch (\Exception $e) {
            Log::error('Error storing reservation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat reservasi: ' . $e->getMessage())->withInput();
        }
    }

    private function generateReservationCode()
    {
        $randomString = strtoupper(Str::random(6)); 
        $timestamp = now()->format('Ymd');

        return 'RSV-' . $timestamp . '-' . $randomString;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $customers = Customer::all(); 
        return view('pages.reservation.edit', compact('reservation', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'customer_name'    => 'required|string|max:255',
                'customer_phone'   => 'required|string|max:15',
                'notes'            => 'nullable|string',
                'table_number'     => 'required|string|max:50',
                'reservation_date' => 'required|date',
                'reservation_time' => 'required',
                'status'           => 'required|string', 
            ]);

            // LOGIKA ANTI-BENTROK SAAT UPDATE (Abaikan ID reservasi ini sendiri)
            $isTableBooked = Reservation::where('table_number', $request->table_number)
                ->where('reservation_date', $request->reservation_date)
                ->where('id', '!=', $id) 
                ->whereIn('status', ['pending', 'confirmed', 'seated'])
                ->exists();

            if ($isTableBooked) {
                return redirect()->back()
                    ->with('error', "Gagal Update! " . $request->table_number . " sudah dihuni/dipesan pelanggan lain pada tanggal " . date('d-m-Y', strtotime($request->reservation_date)) . ".")
                    ->withInput();
            }

            $reservation = Reservation::findOrFail($id);

            $reservation->customer_name = $request->customer_name;
            $reservation->customer_phone = $request->customer_phone;
            $reservation->notes = $request->notes;
            $reservation->table_number = $request->table_number;
            $reservation->reservation_date = $request->reservation_date;
            $reservation->reservation_time = $request->reservation_time;
            
            // 🔥 PENYELAMATAN OTOMATIS: Jika form edit mengirim kata 'booked' atau 'canceled' (typo), 
            // kita amankan konversinya ke string yang ramah struktur database kamu ('pending' / 'cancelled')
            if ($request->status == 'booked') {
                $reservation->status = 'pending';
            } elseif ($request->status == 'canceled') {
                $reservation->status = 'cancelled';
            } else {
                $reservation->status = $request->status;
            }

            $reservation->save();

            return redirect()->route('reservation.index')->with('success', 'Reservation successfully updated');
        } catch (\Exception $e) {
            Log::error('Error updating reservation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui reservasi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('reservation.index')->with('success', 'Reservation successfully deleted');
    }
}