<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resort Reservation System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- #region agent log --}}
    @php
    $logData = [
        'sessionId' => 'debug-session',
        'runId' => 'post-fix',
        'hypothesisId' => 'A',
        'location' => 'welcome.blade.php:8',
        'message' => 'Vite directive removed - page uses inline styles/scripts',
        'data' => [
            'vite_directive_removed' => true,
            'has_inline_styles' => true,
            'has_inline_scripts' => true,
        ],
        'timestamp' => time() * 1000
    ];
    $logDir = base_path('.cursor');
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    $logFile = base_path('.cursor/debug.log');
    file_put_contents($logFile, json_encode($logData) . "\n", FILE_APPEND);
    @endphp
    {{-- #endregion --}}
    <style>
        :root {
            --bg: #f3e8ff;
            --panel: #ffffff;
            --accent: #9333ea;
            --accent-hover: #7e22ce;
            --text: #1b1b1b;
            --muted: #6b7280;
            --border: #e5e7eb;
            --danger: #ef4444;
            --success: #16a34a;
            --radius: 12px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .title-project {
            background: var(--panel);
            border: 2px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .title-project h1 {
            font-size: 2rem;
            color: var(--accent);
            font-weight: 700;
        }
        .forms-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        @media (max-width: 968px) {
            .forms-section {
                grid-template-columns: 1fr;
            }
        }
        .form-panel {
            background: var(--panel);
            border: 2px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .form-panel h2 {
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: var(--accent);
            border-bottom: 2px solid var(--border);
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 6px;
            color: var(--muted);
        }
        input, select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 1rem;
            background: #fff;
            transition: all 0.2s;
        }
        input:hover, select:hover {
            border-color: var(--accent);
        }
        input:focus, select:focus {
            outline: 2px solid var(--accent);
            border-color: var(--accent);
        }
        .submit-section {
            grid-column: 2;
            display: flex;
            align-items: flex-end;
        }
        @media (max-width: 968px) {
            .submit-section {
                grid-column: 1;
            }
        }
        .submit-button {
            width: 100%;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: var(--radius);
            padding: 14px 24px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(147, 51, 234, 0.2);
        }
        .submit-button:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(147, 51, 234, 0.3);
        }
        .submit-button:active {
            transform: translateY(0);
        }
        .submit-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .database-section {
            background: var(--panel);
            border: 2px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .database-header {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
            align-items: center;
        }
        @media (max-width: 768px) {
            .database-header {
                grid-template-columns: 1fr;
            }
        }
        .database-header h2 {
            font-size: 1.5rem;
            color: var(--accent);
            margin: 0;
        }
        .search-filter {
            display: flex;
            gap: 10px;
        }
        .search-input {
            flex: 1;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 1rem;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        thead {
            background: var(--accent);
            color: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        th {
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        tbody tr {
            transition: background 0.2s;
        }
        tbody tr:hover {
            background: #f9fafb;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-view {
            background: #3b82f6;
            color: white;
        }
        .btn-view:hover {
            background: #2563eb;
            transform: scale(1.05);
        }
        .btn-edit {
            background: #f59e0b;
            color: white;
        }
        .btn-edit:hover {
            background: #d97706;
            transform: scale(1.05);
        }
        .btn-delete {
            background: var(--danger);
            color: white;
        }
        .btn-delete:hover {
            background: #dc2626;
            transform: scale(1.05);
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
        }
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: white;
            border-radius: var(--radius);
            padding: 32px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 16px;
        }
        .modal-header h3 {
            font-size: 1.5rem;
            color: var(--accent);
        }
        .close-modal {
            background: none;
            border: none;
            font-size: 2rem;
            cursor: pointer;
            color: var(--muted);
            transition: color 0.2s;
        }
        .close-modal:hover {
            color: var(--danger);
        }
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 640px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }
        .detail-item {
            margin-bottom: 16px;
        }
        .detail-item label {
            font-weight: 700;
            color: var(--muted);
            font-size: 0.85rem;
        }
        .detail-item p {
            margin-top: 4px;
            font-size: 1rem;
            color: var(--text);
        }
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-weight: 600;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--muted);
        }
        .loading {
            text-align: center;
            padding: 20px;
            color: var(--muted);
        }
        footer {
            background: var(--panel);
            border: 2px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            margin-top: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        footer p {
            color: var(--muted);
            font-size: 0.9rem;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Title Project -->
        <div class="title-project">
            <h1>🏖️ Resort Reservation System</h1>
        </div>

        <!-- Forms Section -->
        <div class="forms-section">
            <!-- Personal Information Form -->
            <div class="form-panel">
                <h2>Personal Information Form</h2>
                <form id="reservationForm">
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number (09XXXXXXXXX) *</label>
                        <input type="tel" id="phone_number" name="phone_number" pattern="09[0-9]{9}" placeholder="09123456789" required>
                    </div>
                    <div class="form-group">
                        <label for="municipality_city">Municipality/City *</label>
                        <select id="municipality_city" name="municipality_city" required>
                            <option value="">-- Select Municipality/City --</option>
                            <!-- Bicol Region Municipalities -->
                            <option value="Bulan">Bulan</option>
                            <option value="Irosin">Irosin</option>
                            <option value="Legazpi">Legazpi</option>
                            <option value="Matnog">Matnog</option>
                            <!-- Other Common Cities in the Philippines -->
                            <option value="Manila">Manila</option>
                            <option value="Quezon City">Quezon City</option>
                            <option value="Makati">Makati</option>
                            <option value="Cebu City">Cebu City</option>
                            <option value="Davao City">Davao City</option>
                            <option value="Baguio">Baguio</option>
                            <option value="Boracay">Boracay</option>
                            <option value="Palawan">Palawan</option>
                            <option value="Bohol">Bohol</option>
                            <option value="Siargao">Siargao</option>
                            <option value="Batangas">Batangas</option>
                            <option value="Laguna">Laguna</option>
                            <option value="Cavite">Cavite</option>
                            <option value="Rizal">Rizal</option>
                            <option value="Bulacan">Bulacan</option>
                            <option value="Iloilo City">Iloilo City</option>
                            <option value="Bacolod">Bacolod</option>
                            <option value="Cagayan de Oro">Cagayan de Oro</option>
                            <option value="Zamboanga City">Zamboanga City</option>
                            <option value="Taguig">Taguig</option>
                            <option value="Pasig">Pasig</option>
                            <option value="Marikina">Marikina</option>
                            <option value="Muntinlupa">Muntinlupa</option>
                            <option value="Las Piñas">Las Piñas</option>
                            <option value="Parañaque">Parañaque</option>
                            <option value="Valenzuela">Valenzuela</option>
                            <option value="Caloocan">Caloocan</option>
                            <option value="Pasay">Pasay</option>
                            <option value="Mandaluyong">Mandaluyong</option>
                            <option value="San Juan">San Juan</option>
                            <option value="Pateros">Pateros</option>
                            <option value="Malabon">Malabon</option>
                            <option value="Navotas">Navotas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user_role">User Role *</label>
                        <select id="user_role" name="user_role" required>
                            <option value="">-- Select User Role --</option>
                            <option value="Tourist">Tourist</option>
                            <option value="Resort Owner">Resort Owner</option>
                            <option value="Boat Owner">Boat Owner</option>
                            <option value="System Administrator">System Administrator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="country">Country *</label>
                        <select id="country" name="country" required>
                            <option value="">-- Select Country --</option>
                            <option value="Philippines">Philippines</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Canada">Canada</option>
                            <option value="Australia">Australia</option>
                            <option value="Japan">Japan</option>
                            <option value="South Korea">South Korea</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="China">China</option>
                            <option value="India">India</option>
                            <option value="Germany">Germany</option>
                            <option value="France">France</option>
                            <option value="Spain">Spain</option>
                            <option value="Italy">Italy</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Booking Reservation Form -->
            <div class="form-panel">
                <h2>Booking Reservation Form</h2>
                <form id="bookingForm">
                    <div class="form-group">
                        <label for="resort">Resort *</label>
                        <select id="resort" name="resort" required>
                            <option value="">-- Select Resort --</option>
                            <option value="Kuya Boy Beach Resort">Kuya Boy Beach Resort</option>
                            <option value="Ocean Breeze Beach Resort">Ocean Breeze Beach Resort</option>
                            <option value="Arcadia Beach Resort">Arcadia Beach Resort</option>
                            <option value="Mountain Villa Beach Resort">Mountain Villa Beach Resort</option>
                            <option value="Calintaan Beach Resort">Calintaan Beach Resort</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="check_in_date">Check In Date *</label>
                        <input type="date" id="check_in_date" name="check_in_date" required>
                    </div>
                    <div class="form-group">
                        <label for="check_out_date">Check Out Date</label>
                        <input type="date" id="check_out_date" name="check_out_date">
                    </div>
                    <div class="form-group">
                        <label for="number_of_guests">Number of Guests *</label>
                        <input type="number" id="number_of_guests" name="number_of_guests" min="1" max="100" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_method">Payment Method *</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="GCash">GCash</option>
                            <option value="PayPal">PayPal</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="PayMaya">PayMaya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                </form>
            </div>

            <!-- Submit Button -->
            <div class="submit-section">
                <button type="button" class="submit-button" id="submitBtn">Submit Reservation</button>
            </div>
        </div>

        <!-- Database Section -->
        <div class="database-section">
            <div class="database-header">
                <h2>Reservations Database</h2>
                <div class="search-filter">
                    <input type="text" class="search-input" id="searchInput" placeholder="Search by name, email, phone, resort...">
                </div>
            </div>
            <div id="alertContainer"></div>
            <div class="table-container">
                <div id="loadingIndicator" class="loading" style="display: none;">Loading...</div>
                <table id="reservationsTable" style="display: none;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Guest</th>
                            <th>Email</th>
                            <th>Resort</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>No. of Guests</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="reservationsBody">
                    </tbody>
                </table>
                <div id="emptyState" class="empty-state" style="display: none;">
                    <p>No reservations found. Create your first reservation above!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Reservation Details</h3>
                <button class="close-modal" onclick="closeViewModal()">&times;</button>
            </div>
            <div id="viewModalContent"></div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Reservation</h3>
                <button class="close-modal" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="detail-grid">
                    <div class="form-group">
                        <label for="edit_name">Name *</label>
                        <input type="text" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email Address *</label>
                        <input type="email" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone_number">Phone Number *</label>
                        <input type="tel" id="edit_phone_number" name="phone_number" pattern="09[0-9]{9}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_municipality_city">Municipality/City *</label>
                        <select id="edit_municipality_city" name="municipality_city" required>
                            <!-- Bicol Region Municipalities -->
                            <option value="Bulan">Bulan</option>
                            <option value="Irosin">Irosin</option>
                            <option value="Legazpi">Legazpi</option>
                            <option value="Matnog">Matnog</option>
                            <!-- Other Common Cities in the Philippines -->
                            <option value="Manila">Manila</option>
                            <option value="Quezon City">Quezon City</option>
                            <option value="Makati">Makati</option>
                            <option value="Cebu City">Cebu City</option>
                            <option value="Davao City">Davao City</option>
                            <option value="Baguio">Baguio</option>
                            <option value="Boracay">Boracay</option>
                            <option value="Palawan">Palawan</option>
                            <option value="Bohol">Bohol</option>
                            <option value="Siargao">Siargao</option>
                            <option value="Batangas">Batangas</option>
                            <option value="Laguna">Laguna</option>
                            <option value="Cavite">Cavite</option>
                            <option value="Rizal">Rizal</option>
                            <option value="Bulacan">Bulacan</option>
                            <option value="Iloilo City">Iloilo City</option>
                            <option value="Bacolod">Bacolod</option>
                            <option value="Cagayan de Oro">Cagayan de Oro</option>
                            <option value="Zamboanga City">Zamboanga City</option>
                            <option value="Taguig">Taguig</option>
                            <option value="Pasig">Pasig</option>
                            <option value="Marikina">Marikina</option>
                            <option value="Muntinlupa">Muntinlupa</option>
                            <option value="Las Piñas">Las Piñas</option>
                            <option value="Parañaque">Parañaque</option>
                            <option value="Valenzuela">Valenzuela</option>
                            <option value="Caloocan">Caloocan</option>
                            <option value="Pasay">Pasay</option>
                            <option value="Mandaluyong">Mandaluyong</option>
                            <option value="San Juan">San Juan</option>
                            <option value="Pateros">Pateros</option>
                            <option value="Malabon">Malabon</option>
                            <option value="Navotas">Navotas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_user_role">User Role *</label>
                        <select id="edit_user_role" name="user_role" required>
                            <option value="Tourist">Tourist</option>
                            <option value="Resort Owner">Resort Owner</option>
                            <option value="Boat Owner">Boat Owner</option>
                            <option value="System Administrator">System Administrator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_country">Country *</label>
                        <select id="edit_country" name="country" required>
                            <option value="Philippines">Philippines</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Canada">Canada</option>
                            <option value="Australia">Australia</option>
                            <option value="Japan">Japan</option>
                            <option value="South Korea">South Korea</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="China">China</option>
                            <option value="India">India</option>
                            <option value="Germany">Germany</option>
                            <option value="France">France</option>
                            <option value="Spain">Spain</option>
                            <option value="Italy">Italy</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_resort">Resort *</label>
                        <select id="edit_resort" name="resort" required>
                            <option value="Kuya Boy Beach Resort">Kuya Boy Beach Resort</option>
                            <option value="Ocean Breeze Beach Resort">Ocean Breeze Beach Resort</option>
                            <option value="Arcadia Beach Resort">Arcadia Beach Resort</option>
                            <option value="Mountain Villa Beach Resort">Mountain Villa Beach Resort</option>
                            <option value="Calintaan Beach Resort">Calintaan Beach Resort</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_check_in_date">Check In Date *</label>
                        <input type="date" id="edit_check_in_date" name="check_in_date" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_check_out_date">Check Out Date</label>
                        <input type="date" id="edit_check_out_date" name="check_out_date">
                    </div>
                    <div class="form-group">
                        <label for="edit_number_of_guests">Number of Guests *</label>
                        <input type="number" id="edit_number_of_guests" name="number_of_guests" min="1" max="100" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_payment_method">Payment Method *</label>
                        <select id="edit_payment_method" name="payment_method" required>
                            <option value="Credit Card">Credit Card</option>
                            <option value="GCash">GCash</option>
                            <option value="PayPal">PayPal</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="PayMaya">PayMaya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_password">Password *</label>
                        <input type="password" id="edit_password" name="password" required>
                    </div>
                </div>
                <div style="margin-top: 24px; display: flex; gap: 12px; justify-content: flex-end;">
                    <button type="button" class="btn btn-view" onclick="closeEditModal()" style="background: var(--muted);">Cancel</button>
                    <button type="submit" class="btn btn-edit">Update Reservation</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_BASE = '/api/reservations';
        let currentEditId = null;

        // Set default dates
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('check_in_date').value = today;
            document.getElementById('check_out_date').value = today;
            
            // Set min date for check out to be same as check in
            document.getElementById('check_in_date').addEventListener('change', function() {
                const checkInDate = this.value;
                const checkOutInput = document.getElementById('check_out_date');
                checkOutInput.min = checkInDate;
                if (checkOutInput.value && checkOutInput.value < checkInDate) {
                    checkOutInput.value = checkInDate;
                }
            });
            
            loadReservations();
        });

        // Form submission
        document.getElementById('submitBtn').addEventListener('click', async function() {
            const personalForm = document.getElementById('reservationForm');
            const bookingForm = document.getElementById('bookingForm');
            
            if (!personalForm.checkValidity() || !bookingForm.checkValidity()) {
                personalForm.reportValidity();
                bookingForm.reportValidity();
                return;
            }

            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone_number: document.getElementById('phone_number').value,
                municipality_city: document.getElementById('municipality_city').value,
                country: document.getElementById('country').value,
                user_role: document.getElementById('user_role').value,
                resort: document.getElementById('resort').value,
                check_in_date: document.getElementById('check_in_date').value,
                check_out_date: document.getElementById('check_out_date').value || null,
                number_of_guests: parseInt(document.getElementById('number_of_guests').value),
                payment_method: document.getElementById('payment_method').value,
                password: document.getElementById('password').value,
            };

            try {
                const response = await fetch(API_BASE, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    showAlert('Reservation created successfully!', 'success');
                    personalForm.reset();
                    bookingForm.reset();
                    const today = new Date().toISOString().split('T')[0];
                    document.getElementById('check_in_date').value = today;
                    document.getElementById('check_out_date').value = today;
                    document.getElementById('check_out_date').min = today;
                    loadReservations();
                } else {
                    showAlert(data.message || 'Error creating reservation', 'error');
                }
            } catch (error) {
                showAlert('Network error. Please try again.', 'error');
            }
        });

        // Load reservations
        async function loadReservations(search = '') {
            const loading = document.getElementById('loadingIndicator');
            const table = document.getElementById('reservationsTable');
            const emptyState = document.getElementById('emptyState');
            const tbody = document.getElementById('reservationsBody');

            loading.style.display = 'block';
            table.style.display = 'none';
            emptyState.style.display = 'none';

            try {
                const url = search ? `${API_BASE}?search=${encodeURIComponent(search)}` : API_BASE;
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();

                loading.style.display = 'none';

                if (data.data && data.data.length > 0) {
                    tbody.innerHTML = '';
                    data.data.forEach(reservation => {
                        const row = createTableRow(reservation);
                        tbody.appendChild(row);
                    });
                    table.style.display = 'table';
                } else {
                    emptyState.style.display = 'block';
                }
            } catch (error) {
                loading.style.display = 'none';
                showAlert('Error loading reservations', 'error');
            }
        }

        // Create table row
        function createTableRow(reservation) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${reservation.id}</td>
                <td>${reservation.name}</td>
                <td>${reservation.email}</td>
                <td>${reservation.resort}</td>
                <td>${formatDate(reservation.check_in_date)}</td>
                <td>${formatDate(reservation.check_out_date)}</td>
                <td>${reservation.number_of_guests}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-view" onclick="viewReservation(${reservation.id})">View</button>
                        <button class="btn btn-edit" onclick="editReservation(${reservation.id})">Edit</button>
                        <button class="btn btn-delete" onclick="deleteReservation(${reservation.id})">Delete</button>
                    </div>
                </td>
            `;
            return tr;
        }

        // Search functionality
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadReservations(e.target.value);
            }, 300);
        });

        // View reservation
        async function viewReservation(id) {
            try {
                const response = await fetch(`${API_BASE}/${id}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                const reservation = data.data;

                const content = `
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Name</label>
                            <p>${reservation.name}</p>
                        </div>
                        <div class="detail-item">
                            <label>Email</label>
                            <p>${reservation.email}</p>
                        </div>
                        <div class="detail-item">
                            <label>Phone Number</label>
                            <p>${reservation.phone_number}</p>
                        </div>
                        <div class="detail-item">
                            <label>Municipality/City</label>
                            <p>${reservation.municipality_city}</p>
                        </div>
                        <div class="detail-item">
                            <label>Country</label>
                            <p>${reservation.country}</p>
                        </div>
                        <div class="detail-item">
                            <label>User Role</label>
                            <p>${reservation.user_role || 'N/A'}</p>
                        </div>
                        <div class="detail-item">
                            <label>Password</label>
                            <p>${reservation.password || 'N/A'}</p>
                        </div>
                        <div class="detail-item">
                            <label>Resort</label>
                            <p>${reservation.resort}</p>
                        </div>
                        <div class="detail-item">
                            <label>Check-In Date</label>
                            <p>${formatDate(reservation.check_in_date)}</p>
                        </div>
                        <div class="detail-item">
                            <label>Check-Out Date</label>
                            <p>${reservation.check_out_date ? formatDate(reservation.check_out_date) : 'N/A'}</p>
                        </div>
                        <div class="detail-item">
                            <label>Number of Guests</label>
                            <p>${reservation.number_of_guests}</p>
                        </div>
                        <div class="detail-item">
                            <label>Payment Method</label>
                            <p>${reservation.payment_method}</p>
                        </div>
                    </div>
                `;
                document.getElementById('viewModalContent').innerHTML = content;
                document.getElementById('viewModal').classList.add('active');
            } catch (error) {
                showAlert('Error loading reservation details', 'error');
            }
        }

        // Edit reservation
        async function editReservation(id) {
            currentEditId = id;
            try {
                const response = await fetch(`${API_BASE}/${id}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                const reservation = data.data;

                document.getElementById('edit_id').value = reservation.id;
                document.getElementById('edit_name').value = reservation.name;
                document.getElementById('edit_email').value = reservation.email;
                document.getElementById('edit_phone_number').value = reservation.phone_number;
                document.getElementById('edit_municipality_city').value = reservation.municipality_city;
                document.getElementById('edit_country').value = reservation.country;
                document.getElementById('edit_user_role').value = reservation.user_role || '';
                document.getElementById('edit_resort').value = reservation.resort;
                document.getElementById('edit_check_in_date').value = reservation.check_in_date;
                document.getElementById('edit_check_out_date').value = reservation.check_out_date || '';
                document.getElementById('edit_number_of_guests').value = reservation.number_of_guests;
                document.getElementById('edit_payment_method').value = reservation.payment_method;
                document.getElementById('edit_password').value = reservation.password || '';
                
                // Set min date for check out
                const checkInDate = reservation.check_in_date;
                document.getElementById('edit_check_out_date').min = checkInDate;
                
                // Add listener for check in date changes in edit form
                document.getElementById('edit_check_in_date').addEventListener('change', function() {
                    const checkInDate = this.value;
                    const checkOutInput = document.getElementById('edit_check_out_date');
                    checkOutInput.min = checkInDate;
                    if (checkOutInput.value && checkOutInput.value < checkInDate) {
                        checkOutInput.value = checkInDate;
                    }
                });

                document.getElementById('editModal').classList.add('active');
            } catch (error) {
                showAlert('Error loading reservation for editing', 'error');
            }
        }

        // Update reservation
        document.getElementById('editForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            if (!currentEditId) return;

            const formData = {
                name: document.getElementById('edit_name').value,
                email: document.getElementById('edit_email').value,
                phone_number: document.getElementById('edit_phone_number').value,
                municipality_city: document.getElementById('edit_municipality_city').value,
                country: document.getElementById('edit_country').value,
                user_role: document.getElementById('edit_user_role').value,
                resort: document.getElementById('edit_resort').value,
                check_in_date: document.getElementById('edit_check_in_date').value,
                check_out_date: document.getElementById('edit_check_out_date').value || null,
                number_of_guests: parseInt(document.getElementById('edit_number_of_guests').value),
                payment_method: document.getElementById('edit_payment_method').value,
                password: document.getElementById('edit_password').value,
            };

            try {
                const response = await fetch(`${API_BASE}/${currentEditId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    showAlert('Reservation updated successfully!', 'success');
                    closeEditModal();
                    loadReservations();
                } else {
                    showAlert(data.message || 'Error updating reservation', 'error');
                }
            } catch (error) {
                showAlert('Network error. Please try again.', 'error');
            }
        });

        // Delete reservation
        async function deleteReservation(id) {
            if (!confirm('Are you sure you want to delete this reservation?')) return;

            try {
                const response = await fetch(`${API_BASE}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    showAlert('Reservation deleted successfully!', 'success');
                    loadReservations();
                } else {
                    showAlert(data.message || 'Error deleting reservation', 'error');
                }
            } catch (error) {
                showAlert('Network error. Please try again.', 'error');
            }
        }

        // Modal functions
        function closeViewModal() {
            document.getElementById('viewModal').classList.remove('active');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
            currentEditId = null;
        }

        // Close modals on outside click
        window.onclick = function(event) {
            const viewModal = document.getElementById('viewModal');
            const editModal = document.getElementById('editModal');
            if (event.target === viewModal) {
                closeViewModal();
            }
            if (event.target === editModal) {
                closeEditModal();
            }
        }

        // Utility functions
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }

        function showAlert(message, type) {
            const container = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            container.innerHTML = '';
            container.appendChild(alert);
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    </script>
</body>
</html>
