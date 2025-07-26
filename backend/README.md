# 🚀 Laravel Backend - Multi-Auth Post Management

This backend is a Laravel-based API that supports multiple authentication guards (Admin and User), with post management including image upload.

---

## 🛠️ Setup Instructions

### 1. Install dependencies
```bash
composer install
```

---

### 2. Create `.env` and generate app key
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials and app settings.

---

### 3. Set up the database

In `.env`, configure:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run:
```bash
php artisan migrate --seed
```

---

### 4. Link storage (for image uploads)
```bash
php artisan storage:link
```

Uploaded images will be stored in `storage/app/public` and accessible via `public/storage`.

---

### 5. Run the Laravel server
```bash
php artisan serve
```

By default, it runs at: [http://localhost:8000](http://localhost:8000)

---

### 6 . Running Tests

```bash
php artisan test
```


## 🔐 Test Credentials

You can use the following test users to log in and test the API:

### 👤 Regular Users

| Email               | Password |
|---------------------|----------|
| user1@example.com   | 123456   |
| user2@example.com   | 123456   |

### 🛠️ Admin User

| Email               | Password   |
|---------------------|------------|
| admin@example.com   | admin123   |

> 📌 These users are pre-seeded for testing purposes.

---

## 📬 Postman Collection

You can test the API using the Postman collection linked below:

🔗 **[View Postman Collection](https://web.postman.co/workspace/Personal-Workspace~ca93ea78-63f0-47ff-98db-f6ece49dbecd/collection/34837536-39b132a8-b010-4b8e-92db-f2cfb04e23c9?action=share&source=copy-link&creator=34837536)**  
>

---