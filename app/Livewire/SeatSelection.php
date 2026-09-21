<?php 
namespace App\Livewire;

use App\Models\Schedule;
use App\Models\Booking;
use App\Models\BookingSeat;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SeatSelection extends Component
{
    public Schedule $schedule;
    public $selectedSeats = [];     // array of seat IDs
    public $passengerDetails = [];   // key = seat_id, value = ['name'=>..., 'phone'=>...]
    public $contactName, $contactEmail, $contactPhone;
    
    protected $rules = [
        'contactName' => 'required|string|max:255',
        'contactEmail' => 'required|email',
        'contactPhone' => 'required|string|max:20',
        'selectedSeats' => 'required|array|min:1',
        'passengerDetails.*.name' => 'required|string|max:255',
        'passengerDetails.*.phone' => 'nullable|string|max:20',
    ];
    
    public function mount(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }
    
    public function getSeatsProperty()
    {
        $allSeats = $this->schedule->bus->seats;
        $bookedSeatIds = $this->schedule->booked_seats; // from model attribute
        return $allSeats->map(function ($seat) use ($bookedSeatIds) {
            return [
                'id' => $seat->id,
                'number' => $seat->seat_number,
                'is_booked' => in_array($seat->id, $bookedSeatIds),
            ];
        });
    }
    
    public function updatedSelectedSeats($value)
    {
        // When seat selection changes, sync passengerDetails array
        $newDetails = [];
        foreach ($value as $seatId) {
            if (!isset($this->passengerDetails[$seatId])) {
                $newDetails[$seatId] = ['name' => '', 'phone' => ''];
            } else {
                $newDetails[$seatId] = $this->passengerDetails[$seatId];
            }
        }
        $this->passengerDetails = $newDetails;
    }
    
    public function submitBooking2()
    {
        $this->validate();
        
        // Double-check seat availability inside transaction
        DB::transaction(function () {
            $bookedSeatIds = $this->schedule->booked_seats;
            $conflict = array_intersect($this->selectedSeats, $bookedSeatIds);
            if (!empty($conflict)) {
                throw new \Exception('Some seats were just booked. Please refresh.');
            }
            
            $total = count($this->selectedSeats) * $this->schedule->price;
            
            $booking = Booking::create([
                'schedule_id' => $this->schedule->id,
                'contact_name' => $this->contactName,
                'contact_email' => $this->contactEmail,
                'contact_phone' => $this->contactPhone,
                'total_amount' => $total,
                'status' => 'pending',
            ]);
            
            foreach ($this->selectedSeats as $seatId) {
                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $seatId,
                    'passenger_name' => $this->passengerDetails[$seatId]['name'],
                    'passenger_phone' => $this->passengerDetails[$seatId]['phone'] ?? null,
                ]);
            }
        });
        
        session()->flash('message', 'Booking created successfully!');
        return redirect()->route('booking.success', ['booking' => $booking ?? null]);
    }
    
    public function render()
    {
        return view('livewire.seat-selection');
    }
    public function submitBooking()
{
    $this->validate();

    $data = [
        'schedule_id' => $this->schedule->id,
        'selected_seats' => $this->selectedSeats,
        'passenger_details' => $this->passengerDetails,
        'contact_name' => $this->contactName,
        'contact_email' => $this->contactEmail,
        'contact_phone' => $this->contactPhone,
        'total_amount' => count($this->selectedSeats) * $this->schedule->price,
    ];

    session(['booking_data' => $data]);

    return redirect()->route('booking.summary');
}
}