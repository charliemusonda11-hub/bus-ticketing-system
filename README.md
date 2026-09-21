# Bus Ticketing System

A comprehensive Laravel-based bus ticketing platform with real-time seat selection, payment processing, and comprehensive admin/driver management tools.

## Features

### 👥 User Roles & Access Control
- **Customers**: Browse schedules, search routes, book seats, and purchase tickets
- **Admins**: Manage buses, routes, schedules, drivers, and bookings
- **Drivers**: View passenger manifests, validate tickets, and mark passenger boarding status

### 🚌 Core Features
- **Bus Management**: Add and manage bus inventory with company details and vehicle types
- **Route Management**: Create and manage bus routes between origins and destinations
- **Schedule Management**: Publish schedules with departure times, prices, and seat availability
- **Seat Selection**: Interactive seat selection with real-time availability using Livewire
- **Booking System**: Complete booking workflow with customer information and seat assignment
- **Payment Processing**: Secure payment integration with transaction tracking and reference generation
- **Ticket Management**: PDF ticket generation with QR codes and booking reference numbers

### 📊 Admin Dashboard
- View bookings and revenue metrics
- Manage bus fleet, routes, and schedules
- Manage driver accounts and assignments
- Monitor system health and bookings

### 🚗 Driver Portal
- View passenger manifests for assigned schedules
- Mark passengers as boarded
- Validate tickets via QR code scanning
- Real-time passenger tracking

### 🌐 Public Interface
- Homepage with featured routes
- Advanced schedule search (origin, destination, date)
- Browse all available schedules with sorting
- Seat selection with visual layout
- Booking confirmation and ticket download

## Project Structure

```
app/
├── Models/              # Eloquent models (Bus, Route, Schedule, Booking, etc.)
├── Http/Controllers/    # Application controllers
│   ├── Admin/          # Admin panel controllers
│   └── Driver/         # Driver portal controllers
└── Livewire/           # Livewire components (SeatSelection)

resources/
├── views/
│   ├── admin/          # Admin panel templates
│   ├── driver/         # Driver portal templates
│   ├── public/         # Public-facing templates
│   └── booking/        # Booking flow templates
└── css/                # Tailwind styling

database/
├── migrations/         # Database schema
└── seeders/           # Demo data seeders
```

## Key Models
- **User**: System users with roles (admin, driver, customer)
- **Bus**: Bus inventory with company and capacity info
- **Route**: Bus routes connecting origins and destinations
- **Schedule**: Scheduled bus trips with departure times and prices
- **Seat**: Individual seats on each bus
- **Booking**: Customer bookings linking users to schedules
- **BookingSeat**: Junction table for seats within bookings

## Installation

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd Bus_system
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update `.env` with your database credentials
   - Run migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build frontend assets**
   ```bash
   npm run build
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

## Routes

### Public Routes
- `GET /` - Homepage
- `GET /all/schedule` - View all schedules
- `POST /schedules/search` - Search schedules by route and date
- `GET /seat-selection/{schedule}` - Interactive seat selection
- `POST /booking/payment/initiate` - Initiate payment
- `GET /booking/success/{ref}` - Booking confirmation
- `GET /booking/download/{ref}` - Download ticket PDF

### Admin Routes (requires admin role)
- `/admin/` - Dashboard
- `/admin/buses` - Bus management
- `/admin/routes` - Route management
- `/admin/schedules` - Schedule management
- `/admin/bookings` - Booking management
- `/admin/drivers` - Driver management

### Driver Routes (requires driver role)
- `/driver/` - Dashboard
- `/driver/manifest` - View schedules
- `/driver/manifest/{schedule}` - View passenger manifest
- `/driver/validate` - Ticket validation

## Technology Stack
- **Backend**: Laravel 11
- **Frontend**: Tailwind CSS, Alpine.js, Livewire
- **Database**: MySQL/PostgreSQL
- **Payment**: Payment gateway integration
- **PDF Generation**: DomPDF for ticket generation
- **QR Code**: SimpleSoftwareIO QR Code library

## Default Credentials
After running seeders:
- **Admin User**: Check `AdminUserSeeder`
- **Driver User**: Check `DriverUserSeeder`
- **Demo Data**: `BusSystemSeeder` creates sample buses, routes, and schedules

## Development

### Artisan Commands
```bash
# Run tests
php artisan test

# Create migrations
php artisan make:migration migration_name

# Create models and controllers
php artisan make:model ModelName -mc
```

### Frontend Development
```bash
# Watch for changes
npm run dev

# Build for production
npm run build
```

## Support

For issues, feature requests, or questions, please open an issue in the project repository.

## License

This project is open-sourced software licensed under the MIT license.
