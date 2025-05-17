# Crispy Go Backend

<!-- <div align="center">
  <img src="https://media.tenor.com/hvtdgApch4AAAAAi/chicken.gif" alt="Backend Chicken" width="200"/>
</div> -->

## 📝 Deskripsi

**Crispy Go** backend adalah RESTful API berbasis Laravel untuk melayani kebutuhan pemesanan ayam krispi via web. API ini mengatur data seperti:

- Menu ayam krispi
- Blog
- Data pemesanan
- Newsletter
- Kontak

API ini akan digunakan oleh frontend web yang dibuat di repo https://github.com/salmanabdurrahman/crispy-go-fe

## ⚙️ Cara Menjalankan

1.  **Clone repo-nya**

    ```bash
    git clone https://github.com/salmanabdurrahman/crispy-go-be.git
    cd crispy-go-be
    ```

2.  **Install dependency**

    ```bash
    composer install
    ```

3.  **Buat file `.env`**

    ```bash
    cp .env.example .env
    ```

4.  **Generate app key & config cache**

    ```bash
    php artisan key:generate
    php artisan config:cache
    ```

5.  **Setup database**

    - Buat database `crispy_go_be`
    - Sesuaikan `.env` bagian:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=crispy_go_be
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    dan juga bagian

    ```env
    # password untuk admin (contoh admin123)
    ADMIN_PASSWORD=
    # email untuk admin (contoh superadmin@crispygo.store)
    ADMIN_EMAIL=
    # token untuk autentikasi API pada frontend (contoh: myRandomSecureToken123)
    API_STATIC_TOKEN=
    # URL untuk dashboard web (contoh dashboard.crispygo.store)
    APP_DASHBOARD_URL=
    ```

6.  **Migrasi dan seed data**

    ```bash
    php artisan migrate --seed
    ```

7.  **Jalankan server**

    ```bash
    php artisan serve
    ```

8.  **Akses API**

    Default: `http://localhost:8000/api`
    Jangan lupa gunakan static key-nya pada Bearer Token agar datanya dapat diambil. Contoh:
    `Authorization: Bearer myRandomSecureToken123`

## 📌 Endpoint Umum

| Method | Endpoint          | Deskripsi           |
| ------ | ----------------- | ------------------- |
| GET    | /api/menus        | Daftar menu ayam    |
| GET    | /api/blogs        | Daftar blog         |
| GET    | /api/blogs/{slug} | Lihat blog          |
| POST   | /api/newsletter   | Subsribe newsletter |
| POST   | /api/contact      | Kirim pesan         |
| POST   | /api/order        | Buat pesanan        |
