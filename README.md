# Laravel Multi-Auth Post Management App

A Laravel application with multiple authentication systems (Admin & User) and a robust post management system, including image uploads. This project is split into two main parts: the **backend** (Laravel) and the **frontend** (Vue).

---

## 🔍 Project Overview

This full-stack web app allows admins and users to interact with a post management system:

- **Admins** can view, edit, and delete **all** posts.
- **Users** can manage (create, edit, delete) **only their own** posts.
- Posts can include an image (`pic`).

---

## ✨ Features

### 🔐 Authentication

- Separate login pages for **Admin** and **User**.
- Role-based access control.
- Middleware protection for routes.

### 📝 Post Management

- Users can:
  - Create new posts with optional images.
  - Edit and delete only their posts.

- Admins can:
  - View all posts.
  - Edit and delete any post.

### 🖼️ Image Upload

- Each post can include a picture.
- Secure image upload and storage.

---

## ⚙️ Backend Setup

See [`backend/README.md`](backend/README.md) for full instructions on setting up the Laravel backend, including:

- Environment setup
- Database configuration
- Running migrations
- Auth scaffolding
- Post CRUD APIs

---

## 💻 Frontend Setup

See [`frontend/README.md`](frontend/README.md) for instructions on setting up the frontend, including:

- Installation
- Routing setup for Admin/User
- API integration
- UI for managing posts and authentication

---
