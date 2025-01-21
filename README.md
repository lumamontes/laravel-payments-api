# Laravel Payments Manager

### Simple API for managing transactions, invoices, and user balances.

---

## ✨ Features
- **User Authentication** – Token-based authentication with Laravel Sanctum.
- **Payments & Withdrawals** – Handle user transactions, including deposits & withdrawals.
- **Invoice Management** – Create, track, and mark invoices as paid or pending.
- **Balance Tracking** – Automatically update and retrieve user balances.

---

## 🚀 Installation

### 1️⃣ Clone the Repository
```sh
git clone https://github.com/YOUR_USERNAME/laravel-payments-manager.git
cd laravel-payments-manager
```

### 2️⃣ Install Dependencies
```sh
./vendor/bin/sail composer install
```

### 3️⃣ Set Up Environment
```sh
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

### 4️⃣ Set Up Database
```sh
./vendor/bin/sail artisan migrate --seed
```

### 5️⃣ Start the Server
```sh
./vendor/bin/sail up -d
```

---

## 🔑 Authentication
This project uses Laravel Sanctum for authentication. To access protected routes, include a Bearer Token in the request header.

```sh
Authorization: Bearer YOUR_ACCESS_TOKEN
```

---

## 📖 API Endpoints

### 📝 User Authentication
| Method | Endpoint       | Description            |
|--------|----------------|------------------------|
| POST   | /api/register  | Register a new user    |
| POST   | /api/login     | Log in and get a token |
| POST   | /api/logout    | Log out and revoke token|

### 💳 Transactions
| Method | Endpoint            | Description                |
|--------|---------------------|----------------------------|
| POST   | /api/transactions   | Create a payment or withdrawal |
| GET    | /api/transactions   | Get user transactions      |

### 🧾 Invoices
| Method | Endpoint            | Description                |
|--------|---------------------|----------------------------|
| POST   | /api/invoices       | Create an invoice          |
| GET    | /api/invoices       | List all invoices          |
| PUT    | /api/invoices/{id}  | Update an invoice          |
| DELETE | /api/invoices/{id}  | Delete an invoice          |

---

## ✅ Running Tests
To run PHPUnit tests:

```sh
./vendor/bin/sail artisan test
```