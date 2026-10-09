# IT0049 Sison TFA4 POS Authentication

This project extends the TFA3 POS application with staff login, PHP password hashing, CodeIgniter sessions, a route filter, and logout. It keeps the TFA3 customer and user pages, avatars, database records, and visual layout.

## Features

- Login with a username and password checked using `password_verify()`.
- Hash passwords with `password_hash()` when adding a user.
- Require a signed-in session for the dashboard and customer/user routes.
- Regenerate the session ID after login and destroy the session at logout.
- Keep password hashes out of the user list sent to views.
- Use CSRF protection for the login, logout, and account forms.
- Preserve the TFA3 minimal POS layout and Stark sample records.

## Requirements

- PHP 8.2 or newer
- Composer
- MySQL or MariaDB
- PHP extensions `mysqli`, `fileinfo`, and `gd`

## Run on Windows with XAMPP

1. Start **Apache** and **MySQL** in XAMPP.
2. Open this `IT0049-Sison` folder in VS Code and choose **Terminal → New Terminal**.
3. Install dependencies:

   ```powershell
   composer install
   ```

4. Copy `.env.example` to `.env` in this folder. Update the database values if your MySQL username or password is different.
5. In phpMyAdmin, create a database named `pos_database` and import `sql/tfa4_database.sql`. If you already have the TFA3 database, keep it and run the migration in the next step.
6. Run the migration to add and populate the password column:

   ```powershell
   php spark migrate
   ```

   The migration assigns the existing sample users the demo password `POSdemo2026!` and stores it as a hash. The demo accounts include `jon.snow`, `robb.stark`, `ned.stark`, `sansa.stark`, and `joffrey.lannister`.
7. Start the application:

   ```powershell
   php spark serve --port 8080
   ```

8. Open `http://localhost:8080/login` and sign in with username `jon.snow` and password `POSdemo2026!`.

The shared sample password is for local coursework testing only. Use test data and replace demo credentials before exposing a real application publicly.

## Pages to test

- `/login` — public login form
- `/` — protected POS dashboard
- `/customers` — protected customer list
- `/customers/new` and `/customers/{id}/edit` — protected customer forms
- `/users` — protected user list
- `/users/new` and `/users/{id}/edit` — protected user forms
- `POST /logout` — ends the current session and returns to the login page

Test these cases: open `/customers` while logged out and confirm it redirects to login; submit a wrong password and confirm the same general error appears; sign in and confirm the dashboard and account pages open; log out and confirm protected pages require login again. Add a new user and confirm a password is required.

## Database files

- `sql/tfa4_database.sql` is the TFA4 database export with the sample customer and user rows.
- `sql/pos_database.sql` is retained as the original TFA3 export.
- `app/Database/Migrations/2026-10-09-160000_AddPasswordToUsers.php` adds the required password column and hashes passwords for existing accounts.

Run the migration after importing the database export. Do not commit `.env`, real credentials, or personal photos.

## GitHub repository

Create a new repository under `johneinstein23` named `IT0049-Sison`, then run these commands in the VS Code terminal opened in this folder:

```powershell
git init -b main
git add .
git commit -m "Complete IT0049 TFA4 sessions and authentication"
git remote add origin https://github.com/johneinstein23/IT0049-Sison.git
git push -u origin main
```

The `.gitignore` excludes `.env`, `vendor/`, and uploaded avatars.

## Short public demo with Cloudflare

For a temporary classroom demo, keep XAMPP MySQL, the CodeIgniter server, and `cloudflared` running. In a second terminal, run:

```powershell
cloudflared tunnel --url http://localhost:8080
```

Open the generated `https://…trycloudflare.com/login` URL. The random URL stops working when the tunnel process ends, and Quick Tunnels are for testing rather than permanent hosting.

In VS Code, open **View → Terminal**, then open the **Ports** tab in the bottom panel and forward port `8080` if you want VS Code to show a forwarded address. VS Code port forwarding and a Cloudflare Quick Tunnel produce separate URLs. Use the Cloudflare URL for the Cloudflare demo. Set `app.baseURL` in `.env` to that exact HTTPS URL with a trailing slash, then restart `php spark serve` so the generated links keep using the public address. A VS Code port marked **Public** is accessible to anyone with its link, so do not expose real customer information or production credentials.
