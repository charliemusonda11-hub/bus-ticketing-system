<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333;">

    <h2>Booking Confirmed 🚌</h2>

    <p>Hello {{ $booking->contact_name }},</p>

    <p>
        Thank you for booking with us.
        Your payment has been successfully received and your booking is confirmed.
    </p>

    <p>
        <strong>Booking Reference:</strong>
        {{ $booking->booking_reference }}
    </p>

    <p>
        <strong>Total Paid:</strong>
        K{{ number_format($booking->total_amount, 2) }}
    </p>

    <p>
        Your bus ticket is attached to this email as a PDF.
        Please download it and present it when boarding.
    </p>

    <p>
        Thank you for choosing us.
    </p>

    <p>
        Regards,<br>
        {{ $booking->schedule?->bus?->company_name ?? 'Bus Booking Team' }}
    </p>

</body>
</html>