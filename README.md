# CRUD Perpustakaan - PHP Native + Tailwind (DaisyUI)

Project ini adalah tugas UKK membuat aplikasi manajemen perpustakaan sederhana menggunakan PHP Native (tanpa framework) dan Tailwind CSS (dengan DaisyUI). Mendukung fitur CRUD (Create, Read, Update, Delete) untuk buku dan user.

## Cara Prompt AI yang Efektif

Untuk memaksimalkan bantuan AI seperti ChatGPT, gunakan prompt yang spesifik, jelas, dan berkonteks.

### ✅ Contoh prompt yang benar:

"Buatkan halaman edit user dengan form menggunakan Tailwind DaisyUI. ID user diambil dari $\_GET['id']. Data berasal dari MySQL menggunakan mysqli."

### ❌ Contoh prompt yang buruk:

"Tambahin fitur ini dong"

## VS Code Extension

Beberapa VS Code extension yang disarankan:

1. PHP IntelliSense
2. Error Lens
3. HTML Snippets
4. Tailwind CSS IntelliSense

## Struktur folder yang disarankan

```
/perpustakaan
│
├── auth/
│   ├── login.php
│   └── logout.php
│
├── buku/
│   ├── create.php
│   ├── delete.php
│   ├── edit.php
│   └── index.php
│
├── user/
│   ├── create.php
│   ├── delete.php
│   ├── edit.php
│   └── index.php
│
├── hash.php
├── index.php
└── koneksi.php
```

## DaisyUI + Tailwind (CDN)

Taruh cdn ini dibagian tag <head>

```php
<link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
```
