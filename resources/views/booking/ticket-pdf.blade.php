<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bus Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
        }

        .ticket-box {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            color: #4f46e5;
        }

        .info {
            margin-bottom: 15px;
        }

        .info p {
            margin: 4px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th {
            background: #f3f4f6;
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .total {
            text-align: right;
            margin-top: 15px;
            font-size: 16px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="ticket-box">

    <!-- HEADER -->
    
    <div class="header">
    <h2>
        {{ $booking->schedule?->bus?->company_name ?? 'N/A' }}
        🚌 Bus Ticket
    </h2>

    <p>Travel Receipt</p>
</div>

    <!-- BOOKING INFO -->
    <div class="info">
        <p><strong>Reference:</strong> {{ $booking->booking_reference }}</p>
        <p><strong>Bus Company:</strong> {{ $booking->schedule?->bus?->company_name ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ optional($booking->created_at)->format('d M Y') }}</p>
    </div>

    <!-- PASSENGERS TABLE -->
    <h3>Passengers</h3>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Seat Number</th>
                <th>Passenger Name</th>
            </tr>
        </thead>
        <tbody>
            @forelse($booking->seats as $index => $seat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $seat->seat?->seat_number ?? 'N/A' }}</td>
                    <td>{{ $seat->passenger_name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No passengers found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total">
        <strong>Total Paid: K{{ number_format($booking->total_amount, 2) }}</strong>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Thank you for booking with us 🙏</p>
        <p>Please present this ticket during boarding</p>
    </div>

</div>

</body>
</html>