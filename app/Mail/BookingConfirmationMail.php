<?php

namespace App\Mail;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        $pdf = Pdf::loadView('booking.ticket-pdf', [
            'booking' => $this->booking
        ]);

        return $this->subject(
                'Bus Booking Confirmation - ' . $this->booking->booking_reference
            )
            ->view('emails.booking-confirmation')
            ->attachData(
                $pdf->output(),
                'Bus-Ticket-' . $this->booking->booking_reference . '.pdf',
                [
                    'mime' => 'application/pdf',
                ]
            );
    }
}