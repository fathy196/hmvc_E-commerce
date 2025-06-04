# 🧠 Laravel HMVC E-commerce Backend Assessment

This project demonstrates a modular **Laravel 12** backend system using the **HMVC (Hierarchical Model View Controller)**
---

## 🔧 Features

### 📦 Admin Module
- CRUD operations for **Products** and **Categories**
- Assign products to related categories
- Import & export products using Excel (via [Laravel Excel](https://laravel-excel.com/)) with **queues**

### 🛒 User Module (API)
- **User authentication** (Register / Login) using Laravel Sanctum
- Browse all **products** and **categories**
- Place an **order** with multiple products
- Store shipping address and payment method
- Integrate with any **payment gateway** (Paymob used here)
- Get Paymob payment iframe URL for redirection

---

## 📁 Modules Structure

- `Modules/Admin`
  - Models: `Product`, `Category`
  - Features: Product/Category CRUD, Excel Import/Export
- `Modules/User`
  - Models: `Order`, `OrderItem`
  - Features: Auth, Order placement, Payment integration (API)

---

## 🔐 Authentication

Sanctum is used for token-based API authentication. Include the token in headers:

## 📥 API Endpoints

### 🧑‍💻 Authentication
| Method | Endpoint           | Description               |
|--------|--------------------|---------------------------|
| POST   | `/api/register` | Register a new user       |
| POST   | `/api/login`    | Login and get auth token  |

---

### 📦 Products & Categories
| Method | Endpoint                  | Description                         |
|--------|---------------------------|-------------------------------------|
| GET    | `/api/v1/categories` | Get all categories                  |
| GET    | `/api/v1/products`   | Get paginated list of products      |
| GET    | `/api/v1/products/{id}` | Get details for a specific product |

---

### 🛒 Orders & Payments
| Method | Endpoint                         | Description                    |
|--------|----------------------------------|--------------------------------|
| POST   | `/api/v1/orders`            | Create a new order             |
| POST   | `/api/v1/checkout/{order_id}` | Initiate Paymob payment iframe |

---


> 🔐 All `/v1/...` routes require `Authorization: Bearer {token}` header (Sanctum).

