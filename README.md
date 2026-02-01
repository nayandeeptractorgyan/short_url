# URL Shortener

A role-based URL shortening service built with Laravel 11 and MySQL.

## Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+

## Setup

**1. Clone the repository**
```bash
git clone <repo-url>
cd url-shortener
```

**2. Install dependencies**
```bash
composer install
```

**3. Create and configure `.env`**
```bash
copy .env.example .env
php artisan key:generate
```

Open `.env` and set your MySQL credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=your_password
```

Make sure you have created the `url_shortener` database in MySQL first:
```sql
CREATE DATABASE url_shortener;
```

**4. Run migrations and seed**
```bash
php artisan migrate
php artisan db:seed
```

This creates the SuperAdmin account:
- Email: `superadmin@example.com`
- Password: `password`

**5. Start the server**
```bash
php artisan serve
```

Visit `http://localhost:8000`

## Running Tests

```bash
php artisan test
```

Tests use `RefreshDatabase` so they run against your configured MySQL database. Make sure your `.env` is set up before running tests.

## Roles

| Role | Can Create URLs | Can See URLs | Can Invite |
|---|---|---|---|
| SuperAdmin | No | All URLs across all companies | Admin (to a new company) |
| Admin | Yes | All URLs in own company | Admin or Member (in own company) |
| Member | Yes | Only own URLs | No |
| Sales | Yes | Only own URLs | No |
| Manager | Yes | Only own URLs | No |

## How Invitations Work

No email is sent. After creating an invitation, go to **Invitations** — the invite link is shown in the table. Copy that link and share it with the person. They open it, set their name and password, and their account is created.

## AI Tools Used

- Used chatgpt for syntax check of laravel and css of the raw html.
