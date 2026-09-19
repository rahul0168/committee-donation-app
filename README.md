# Committee Donation Mobile Web App (Laravel 13 + SQLite + PWA)

A modern, mobile-first **Committee Donation & Member Pledge Management Application** built with **Laravel 13**, **SQLite**, and **Progressive Web App (PWA)** specifications for native installation on Android devices.

---

## ✨ Features

- **📱 Android PWA Installable**: PWA Manifest, Service Worker offline caching, and interactive **"Install App"** prompt for Android Chrome/Edge.
- **🔐 Admin Authentication**: Protected routes with session authentication & login system.
- **🏛️ Committee & Fund Management**: Single committee focus with target budget progress bars and net balance tracking.
- **👥 Member Directory & Pledges**: Register committee members and track monthly donation pledges.
- **🧾 Instant Receipts**: Auto-generated receipt numbers (`REC-YYYYMM-XXXX`) with printable voucher layout.
- **💬 One-Click WhatsApp Sharing**: Send formatted donation receipts directly to donors on WhatsApp with one click.
- **💸 Expenditure Log**: Track committee operational expenses with category tagging and approval logs.
- **📊 Financial Analytics**: Interactive Chart.js graphs for 6-month financial flows & payment method breakdown (Cash, UPI, Bank Transfer, Cheque).
- **📄 Audit Reports & CSV Export**: Export complete date-filtered donation reports to CSV.

---

## 🛠️ Technology Stack

- **Backend**: Laravel 13 (PHP 8.3+)
- **Database**: SQLite (`database/database.sqlite`)
- **Frontend**: Blade, Tailwind CSS, FontAwesome 6, Chart.js
- **PWA**: Web App Manifest (`manifest.json`), Service Worker (`sw.js`)

---

## 🚀 Quick Start Guide

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & npm (optional)

### Setup & Run Locally

1. **Clone Repository**:
   ```bash
   git clone https://github.com/rahul0168/committee-donation-app.git
   cd committee-donation-app
   ```

2. **Install Composer Dependencies**:
   ```bash
   composer install
   ```

3. **Configure Environment & SQLite Database**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Migrations & Seed Sample Data**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start Development Server**:
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```
   Open `http://localhost:8000` in your browser.

---

## 🔑 Default Admin Login Credentials

- **Email**: `admin@committee.org`
- **Password**: `password`

---

## 📲 How to Install on Android Mobile

1. Open `http://<your-local-ip>:8000` on Android Chrome.
2. Sign in with the Admin credentials.
3. Tap the **Install App** button in the header or select **"Add to Home screen"** from the Chrome menu.
4. Launch the app directly from your Android home screen!

---

## 📜 License
This project is open-source software licensed under the [MIT license](LICENSE).
