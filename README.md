# 🍽️ Foodify API

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white"/>
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/Sanctum-Auth-FF2D20?style=for-the-badge&logo=laravel&logoColor=white"/>
</p>

<p align="center">
  A RESTful API for a <strong>Healthy Food Delivery</strong> mobile application, built with Laravel 13 following clean architecture principles using <strong>Actions</strong>, <strong>Services</strong>, and <strong>Form Requests</strong> patterns.
</p>

---

## ✨ Features

- 🔐 **Authentication** — Phone-based auth with OTP verification via SMS Misr
- 🍱 **Meals & Categories** — Browse meals by category with nutrition details
- ❤️ **Favorites** — Save and manage favorite meals
- 🛒 **Cart** — Add, update, and remove meals from cart
- 💳 **Payment** — Strategy Pattern supporting Card (Paymob), Wallet, and Cash on Delivery
- 👤 **Profile** — Update profile info and change password
- 📦 **Orders** — Place and track orders with full order history

---

## 🏗️ Architecture

```
app/
├── Actions/          # Single-responsibility business logic
│   ├── Auth/
│   ├── Cart/
│   ├── Order/
│   └── Profile/
├── Services/         # External service integrations
│   ├── OtpService.php
│   ├── SmsMisrService.php
│   └── Payment/
│       ├── Contracts/
│       │   └── PaymentStrategy.php   # Interface
│       ├── Strategies/
│       │   ├── CardPayment.php        # Paymob
│       │   ├── WalletPayment.php      # Simulation
│       │   └── CashOnDeliveryPayment.php
│       └── PaymentContext.php         # Strategy selector
├── Http/
│   ├── Controllers/Api/
│   └── Requests/
│       ├── Auth/
│       └── Profile/
├── Models/
└── Traits/
    └── ApiResponseTrait.php
```

---

## 🗄️ Database Schema

```
users               otp_codes           categories
├── id              ├── id              ├── id
├── name            ├── phone           ├── name
├── phone           ├── code            └── image
├── password        ├── type
├── profile_image   ├── is_used         ingredients
└── is_phone_       └── expires_at      ├── id
    verified                            ├── name
                    meals               └── icon
orders              ├── id
├── id              ├── category_id     meal_ingredients
├── user_id         ├── name            ├── meal_id
├── status          ├── description     └── ingredient_id
├── payment_method  ├── image
├── payment_status  ├── price           cart_items
├── subtotal        ├── calories        ├── id
├── delivery_fee    ├── protein         ├── user_id
└── total           ├── carbs           ├── meal_id
                    ├── fat             └── quantity
order_items         ├── fiber
├── id              └── rating          favorites
├── order_id                            ├── id
├── meal_id                             ├── user_id
├── quantity                            └── meal_id
└── price
```

---

## 🚀 Getting Started

### Requirements

- PHP >= 8.3
- Composer
- MySQL 8.0+
- Laravel 13

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-username/foodify-api.git
cd foodify-api

# 2. Install dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Configure your database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foodify
DB_USERNAME=root
DB_PASSWORD=

# 6. Run migrations and seeders
php artisan migrate --seed

# 7. Create storage symlink
php artisan storage:link

# 8. Start the server
php artisan serve
```

---

## ⚙️ Environment Variables

```env
# SMS Misr (OTP)
SMSMISR_USERNAME=your_username
SMSMISR_PASSWORD=your_password
SMSMISR_SENDER=your_sender_token
SMSMISR_ENVIRONMENT=2  # 1=Live, 2=Test

# Paymob (Payment)
PAYMOB_PUBLIC_KEY=your_public_key
PAYMOB_SECRET_KEY=your_secret_key
PAYMOB_INTEGRATION_ID_CARD=your_integration_id
PAYMOB_BASE_URL=https://accept.paymob.com
PAYMOB_HMAC_SECRET=your_hmac_secret
```

---

## 📡 API Endpoints

### 🔐 Authentication

| Method | Endpoint                    | Description                 | Auth |
| ------ | --------------------------- | --------------------------- | ---- |
| POST   | `/api/auth/register`        | Register new user           | ❌   |
| POST   | `/api/auth/verify-otp`      | Verify OTP code             | ❌   |
| POST   | `/api/auth/login`           | Login with phone & password | ❌   |
| POST   | `/api/auth/forgot-password` | Send OTP for password reset | ❌   |
| POST   | `/api/auth/reset-password`  | Reset password with OTP     | ❌   |
| POST   | `/api/auth/logout`          | Logout current session      | ✅   |
| GET    | `/api/auth/me`              | Get authenticated user      | ✅   |

### 🍱 Meals

| Method | Endpoint                    | Description                               | Auth |
| ------ | --------------------------- | ----------------------------------------- | ---- |
| GET    | `/api/meals/categories`     | List all categories                       | ✅   |
| GET    | `/api/meals`                | List all meals                            | ✅   |
| GET    | `/api/meals?category_id=1`  | Filter by category                        | ✅   |
| GET    | `/api/meals?search=chicken` | Search meals                              | ✅   |
| GET    | `/api/meals/{id}`           | Meal details with nutrition & ingredients | ✅   |

### 🛒 Cart

| Method | Endpoint              | Description           | Auth |
| ------ | --------------------- | --------------------- | ---- |
| GET    | `/api/cart`           | View cart with totals | ✅   |
| POST   | `/api/cart`           | Add meal to cart      | ✅   |
| PATCH  | `/api/cart/{meal_id}` | Update quantity       | ✅   |
| DELETE | `/api/cart/{meal_id}` | Remove meal from cart | ✅   |
| DELETE | `/api/cart`           | Clear entire cart     | ✅   |

### ❤️ Favorites

| Method | Endpoint                   | Description           | Auth |
| ------ | -------------------------- | --------------------- | ---- |
| GET    | `/api/favorites`           | List favorite meals   | ✅   |
| POST   | `/api/favorites`           | Add meal to favorites | ✅   |
| DELETE | `/api/favorites/{meal_id}` | Remove from favorites | ✅   |

### 💳 Orders & Payment

| Method | Endpoint           | Description                    | Auth |
| ------ | ------------------ | ------------------------------ | ---- |
| POST   | `/api/orders`      | Place order (card/wallet/cash) | ✅   |
| GET    | `/api/orders`      | Order history                  | ✅   |
| GET    | `/api/orders/{id}` | Order details                  | ✅   |

### 👤 Profile

| Method | Endpoint                       | Description                 | Auth |
| ------ | ------------------------------ | --------------------------- | ---- |
| GET    | `/api/profile`                 | Get profile                 | ✅   |
| POST   | `/api/profile`                 | Update name / profile image | ✅   |
| POST   | `/api/profile/change-password` | Change password             | ✅   |
| GET    | `/api/profile/orders`          | Order history from profile  | ✅   |

---

## 💳 Payment Methods

| Method                         | Provider      | Status        |
| ------------------------------ | ------------- | ------------- |
| Credit / Debit Card            | Paymob (MIGS) | ✅ Live       |
| Wallet (Vodafone Cash / Fawry) | Simulation    | 🔄 Simulation |
| Cash on Delivery               | —             | ✅ Live       |

### Payment Flow (Card)

```
POST /api/orders { "payment_method": "card" }
        ↓
Returns client_secret + public_key
        ↓
Mobile SDK completes payment
        ↓
Paymob sends Webhook → Order status updated
```

---

## 📱 Unified API Response

Every endpoint returns a consistent JSON structure:

```json
{
    "status": true,
    "message": "Success",
    "data": {},
    "errors": null
}
```

---

## 🌱 Seeders

The database comes pre-seeded with:

- **6 Categories** — High Protein, Low Calorie, Balanced Meals, Smoothies, Vegan, Keto
- **28 Ingredients** — Common healthy food ingredients with emoji icons
- **18 Meals** — 3 meals per category with full nutrition facts

```bash
php artisan db:seed
```

---

## 🔒 Security

- Laravel Sanctum for API token authentication
- OTP verification for phone number (15 min expiry)
- HMAC signature verification for Paymob webhooks
- Password hashing via Laravel's built-in `hashed` cast

---

## 🛠️ Tech Stack

| Technology      | Purpose            |
| --------------- | ------------------ |
| Laravel 13      | Backend Framework  |
| Laravel Sanctum | API Authentication |
| MySQL           | Database           |
| SMS Misr        | OTP SMS Service    |
| Paymob          | Payment Gateway    |
| Laravel Storage | File Uploads       |

---

## 📁 Design Patterns Used

- **Action Pattern** — Single responsibility per business operation
- **Service Layer** — External integrations (SMS, Payment)
- **Strategy Pattern** — Pluggable payment methods
- **Form Requests** — Centralized validation with custom error format
- **Trait** — Unified API response format

---

## 👨‍💻 Author

**Mohamed Adel**

- GitHub: [@MohamedAdel](https://github.com/MOHAMED-ADEL-MA)

---

<p align="center">Built with ❤️ using Laravel 13</p>
