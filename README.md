<p align="center">
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="public/images/nexora-logo-dark.png">
        <source media="(prefers-color-scheme: light)" srcset="public/images/nexora-logo-light.png">
        <img alt="Nexora CRM" height="110" src="public/images/nexora-logo-light.png">
    </picture>
</p>

<p align="center">
    <strong>Intelligent Open-Source CRM Platform built with Laravel 12 &amp; Vue.js 3</strong>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/PHP-8.3%2B-5A4DB9?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3+">
    <img src="https://img.shields.io/badge/Laravel-12.x-01C7F4?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
    <img src="https://img.shields.io/badge/Vue.js-3.4-9E24B7?style=for-the-badge&logo=vuedotjs&logoColor=white" alt="Vue.js 3">
    <img src="https://img.shields.io/badge/License-MIT-D803B3?style=for-the-badge" alt="MIT License">
</p>

---

## Table of Contents

1. [Introduction](#introduction)
2. [Key Features & UI/UX](#key-features--uiux)
3. [Requirements](#requirements)
4. [Step-by-Step Software Downloads & Setup](#step-by-step-software-downloads--setup)
5. [Step-by-Step Project Build & Installation](#step-by-step-project-build--installation)
6. [Running Nexora](#running-nexora)
7. [Production Server Setup (Apache 2 & NGINX)](#production-server-setup-apache-2--nginx)
8. [Default Admin Credentials](#default-admin-credentials)
9. [Development, Testing & Formatting](#development-testing--formatting)
10. [Security Vulnerabilities](#security-vulnerabilities)
11. [License](#license)

---

## Introduction

**Nexora** is a modern, modular Customer Relationship Management (CRM) platform built on **Laravel 12 (PHP 8.3+)**, **Vue.js 3**, and **Tailwind CSS**. It delivers complete customer lifecycle management—from lead capture and pipeline tracking to quotes, emails, activities, workflows, and analytics—wrapped in a responsive, animated interface themed around the Nexora cyan-indigo-magenta palette (`#01C7F4` → `#5A4DB9` → `#D803B3`).

---

## Key Features & UI/UX

- **System-Aware Automatic Dark & Light Mode:** Automatically detects the visitor's OS/device color scheme (`prefers-color-scheme`) on first visit with zero white-flash (FOUC) before paint, and follows system theme changes until overridden.
- **Manual Theme Switcher:** Toggle seamlessly between **Dark Mode** and **Light Mode** at any time from the header bar, login screens, or web installer (persisted in both `localStorage` and `dark_mode` cookie).
- **Logo-Aligned Brand Theme & Animations:** Custom cyan-to-magenta gradient accents, elevated glassmorphic auth cards, staggered dashboard card reveals, interactive hover lifts, backdrop-blurred modals/drawers, and theme-reactive Chart.js visualizations.
- **Complete CRM Modules:**
  - Interactive Dashboard & Funnel Analytics
  - Leads & Multi-Stage Kanban Pipelines
  - Contacts (Persons & Organizations)
  - Quotes & PDF Generation
  - Products & Warehouses
  - Activities, Calendar & Notes
  - Email Client, Templates & Automated Workflows
  - Embeddable WebForms & Role-Based Access Control (ACL)

---

## Requirements

Before installing Nexora, make sure your environment meets the following requirements:

- **SERVER**: Apache 2 or NGINX.
- **RAM**: 3 GB or higher.
- **PHP**: 8.3 or higher
- **Composer**: 2.5 or higher
- **For MySQL users**: 8.0.32 or higher.
- **For MariaDB users**: 11.4 LTS or higher (11.8 LTS recommended).
- **Node.js & npm**: Node.js 18 LTS / 20 LTS or higher (required to build Vite frontend bundles).
- **Git**: 2.30 or higher.

### Required PHP Extensions

Ensure the following PHP extensions are enabled in `php.ini`:

`bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `gd`, `hash`, `intl`, `json`, `mbstring`, `openssl`, `pcre`, `pdo`, `pdo_mysql`, `session`, `tokenizer`, `xml`, `zip`

---

## Step-by-Step Software Downloads & Setup

Follow these steps to download and install the required tools on your machine.

### Step 1: Download & Install Git
- **Download Link:** https://git-scm.com/downloads
- **Windows:** Download the 64-bit Windows installer and accept defaults.
- **macOS:** `brew install git` (or Xcode Command Line Tools).
- **Ubuntu/Debian:** `sudo apt update && sudo apt install -y git`
- Verify: `git --version`

### Step 2: Download & Install PHP 8.3+
- **Official PHP Downloads:** https://www.php.net/downloads.php
- **Windows:**
  - Download **PHP 8.3+ (VS16/VS17 x64 Thread Safe)** ZIP from https://windows.php.net/download/ (or install via **Laravel Herd**: https://herd.laravel.com/windows or **Laragon**: https://laragon.org/download/).
  - Extract PHP to `C:\php`, copy `php.ini-development` to `php.ini`, enable `extension=curl`, `extension=fileinfo`, `extension=gd`, `extension=intl`, `extension=mbstring`, `extension=openssl`, `extension=pdo_mysql`, `extension=zip`, and add `C:\php` to your Windows `PATH`.
- **macOS:**
  ```bash
  brew install php@8.3
  ```
- **Ubuntu / Debian (ondrej/php PPA):**
  ```bash
  sudo apt update && sudo apt install -y software-properties-common
  sudo add-apt-repository ppa:ondrej/php -y
  sudo apt update
  sudo apt install -y php8.3 php8.3-cli php8.3-fpm php8.3-mysql php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-gd php8.3-intl php8.3-bcmath
  ```
- Verify: `php -v` (must show `8.3.x` or higher)

### Step 3: Download & Install Composer 2.5+
- **Download Link:** https://getcomposer.org/download/
- **Windows:** Download and run **Composer-Setup.exe** from https://getcomposer.org/Composer-Setup.exe (point it to your PHP 8.3 `php.exe`).
- **macOS / Linux:**
  ```bash
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  php composer-setup.php --install-dir=/usr/local/bin --filename=composer
  php -r "unlink('composer-setup.php');"
  ```
- Verify: `composer --version` (must show `2.5.0` or higher)

### Step 4: Download & Install Database (MySQL 8.0.32+ OR MariaDB 11.4+ LTS)
Choose **one** of the following databases:

- **Option A — MySQL 8.0.32 or higher:**
  - **Download Link:** https://dev.mysql.com/downloads/mysql/ (or MySQL Installer for Windows: https://dev.mysql.com/downloads/installer/)
  - Create a database named `nexora_crm` (`CREATE DATABASE nexora_crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`).
- **Option B — MariaDB 11.4 LTS or higher (11.8 LTS recommended):**
  - **Download Link:** https://mariadb.org/download/
  - Select **11.8 LTS** (or **11.4 LTS**), install, and create a database named `nexora_crm`.

### Step 5: Download & Install Node.js & npm (for Frontend Build)
- **Download Link:** https://nodejs.org/en/download (choose **LTS 20.x** or **22.x** / **24.x**)
- **macOS:** `brew install node`
- **Ubuntu/Debian:** https://github.com/nodesource/distributions
- Verify: `node -v && npm -v`

### Step 6: Download & Install Web Server (Production / Staging)
- **Apache 2:**
  - Official Site: https://httpd.apache.org/download.cgi
  - Windows All-in-One Bundles (includes Apache 2): https://www.apachelounge.com/download/ or **Laragon** (https://laragon.org/download/)
  - Ubuntu/Debian: `sudo apt install -y apache2 libapache2-mod-php8.3 && sudo a2enmod rewrite`
- **NGINX:**
  - Official Download: https://nginx.org/en/download.html
  - Ubuntu/Debian: `sudo apt install -y nginx`

---

## Step-by-Step Project Build & Installation

Follow these exact commands in order after installing all prerequisites above.

### 1. Clone the Repository

```bash
git clone https://github.com/<your-username>/nexora.git
cd nexora
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Configure Environment Variables

Copy the example environment file and generate an application encryption key:

```bash
# Linux / macOS / Git Bash
cp .env.example .env

# Windows PowerShell
Copy-Item .env.example .env
```

Generate the Laravel `APP_KEY`:

```bash
php artisan key:generate
```

Open `.env` and update your application URL, database, and mail settings:

```env
APP_NAME='Nexora'
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql        # or mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nexora_crm
DB_USERNAME=root
DB_PASSWORD=your_database_password
```

### 4. Build All Frontend Assets (Vite + Tailwind CSS + Vue.js)

Nexora compiles assets for the Admin panel, Installer wizard, WebForm module, and root app. Run the following build commands:

```bash
# 1. Root assets
npm install
npm run build

# 2. Admin UI assets (theme, animations, charts, icons, logos)
cd packages/Webkul/Admin
npm install
npm run build
cd ../../..

# 3. Web Installer UI assets
cd packages/Webkul/Installer
npm install
npm run build
cd ../../..

# 4. WebForm UI assets
cd packages/Webkul/WebForm
npm install
npm run build
cd ../../..
```

> **Windows PowerShell tip:** If you want to skip downloading Playwright browser binaries during `npm install` in `packages/Webkul/Admin`, run:
> ```powershell
> $env:PLAYWRIGHT_SKIP_BROWSER_DOWNLOAD="1"
> ```

### 5. Run the Nexora Installer (Migrations, Storage Link & Admin Setup)

Run the interactive CLI installer to migrate tables, publish assets, seed default pipelines/attributes/roles, and create your administrator account:

```bash
php artisan nexora:install
```

*(Alias `php artisan krayin-crm:install` is also supported for backward compatibility.)*

Alternatively, if you prefer manual database setup:

```bash
php artisan migrate --seed
php artisan storage:link
```

---

## Running Nexora

### Local Development Server

1. Clear cached routes and config (recommended after `.env` changes):

   ```bash
   php artisan optimize:clear
   ```

2. Start the Laravel development server:

   ```bash
   php artisan serve
   ```

3. *(Optional — Frontend Live Reloading)* If you are actively editing CSS or Vue/Blade assets inside Admin, run Vite dev mode in a second terminal:

   ```bash
   cd packages/Webkul/Admin
   npm run dev
   ```

4. Open Nexora in your browser:
   - **App / Login URL:** `http://127.0.0.1:8000/admin/login`
   - **Web Installer (if `.env` is unconfigured):** `http://127.0.0.1:8000`

### Theme Behavior Verification

- **First Visit:** Nexora automatically detects your operating system / browser theme (`prefers-color-scheme: dark` or `light`) before first paint—no manual setup required.
- **Manual Toggle:** Click the Sun/Moon toggle button in the top navigation bar (or top-right pill on login/installer screens) to switch between **Dark** and **Light** mode manually. Your choice is saved in `localStorage` (`nexora_theme`) and the `dark_mode` cookie.

---

## Production Server Setup (Apache 2 & NGINX)

Before deploying to production:

1. Remove dev dependencies and optimize Laravel caches:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
2. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`.
3. Point your web server's **Document Root** to the `public/` directory (never the project root), and ensure `storage/` and `bootstrap/cache/` are writable by the web server user (`www-data` on Linux).

### Apache 2 VirtualHost Example

```apache
<VirtualHost *:80>
    ServerName nexora.yourdomain.com
    DocumentRoot /var/www/nexora/public

    <Directory /var/www/nexora/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/nexora-error.log
    CustomLog ${APACHE_LOG_DIR}/nexora-access.log combined
</VirtualHost>
```

### NGINX Server Block Example

```nginx
server {
    listen 80;
    server_name nexora.yourdomain.com;
    root /var/www/nexora/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## Default Admin Credentials

If you used the default seeder during installation, log in at `/admin/login`:

- **URL:** `http://127.0.0.1:8000/admin/login`
- **Email:** `admin@example.com`
- **Password:** `admin123`

*(If you created custom credentials during `php artisan nexora:install`, use those instead, and change default passwords before going live.)*

---

## Development, Testing & Formatting

```bash
# Run Pest PHP test suite
php artisan test --compact

# Format PHP code (Laravel Pint / PSR-12)
./vendor/bin/pint

# Run JavaScript property tests
npm run test:js
```

---

## Security Vulnerabilities

Please do **not** disclose security vulnerabilities publicly. Review [SECURITY.md](SECURITY.md) and report issues privately to the maintainer.

---

## License

**Nexora** is open-source software licensed under the [MIT License](LICENSE).
Copyright (c) 2026 Isuru Rathnayaka.
