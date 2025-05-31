# 🍕 Pizza Sales Analytics Application

A full-stack application for analyzing pizza sales data and managing orders. This application provides insights into sales patterns, popular items, and detailed order management for pizza businesses.

---

## 🧰 Technology Stack

### Backend
- **Laravel** – PHP Framework for robust backend development
- **MySQL** – Relational database for structured data
- **RESTful API** – Standardized communication between frontend and backend

### Frontend
- **Vue.js** – Reactive JavaScript framework for the user interface
- **Tailwind CSS** – Utility-first CSS framework for styling

### Infrastructure
- **Docker & Docker Compose** – Containerization and orchestration
- **Nginx** – Web server for serving frontend and proxying API requests

---

## 📁 Project Structure

```
pizza-sales/
├── docker-compose.yml          # Docker composition configuration
├── backend/                    # Laravel API application
│   ├── app/                    # Application code
│   ├── config/                 # Configuration files
│   ├── database/               # Database migrations and seeders
│   ├── routes/                 # API routes
│   └── ...
├── frontend/                   # Vue.js frontend application
│   ├── src/                    # Source code
│   └── ...
└── docker/                     # Docker configuration files
    ├── mysql/                  # MySQL configuration
    ├── nginx/                  # Nginx configuration
    └── php/                    # PHP configuration
```

---

## ✨ Features

### 📊 Analytics Dashboard
- Visualized sales metrics
- Average order value tracking
- Peak order time identification
- Order volume trends

### 🧾 Order Management
- Cursor-based pagination for scalable performance
- Detailed order views
- Order filtering by date range

---

## ⚙️ Installation & Setup

### Prerequisites
- Docker
- Docker Compose
- Git

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/pizza-sales.git
   cd pizza-sales
   ```

2. **Start Docker containers**
   ```bash
   docker-compose up -d
   ```

3. **Install backend dependencies**
   ```bash
   docker-compose exec backend composer install
   ```

4. **Set up environment variables**
   ```bash
   cp backend/.env.example backend/.env
   docker-compose exec backend php artisan key:generate
   ```

5. **Run database migrations and seeders**
   ```bash
   docker-compose exec backend php artisan migrate
   docker-compose exec backend php artisan db:seed
   ```

6. **Install frontend dependencies and build assets**
   ```bash
   docker-compose exec frontend npm install
   docker-compose exec frontend npm run build
   ```

7. **Access the application**
   - Frontend: [http://localhost:8080](http://localhost:8080)
   - Backend API: [http://localhost:8000](http://localhost:8000)

---

## 🛠 Development

### Backend Development

```bash
# Run Laravel dev server
docker-compose exec backend php artisan serve

# Migrate DB
docker-compose exec backend php artisan migrate

# Seed DB
docker-compose exec backend php artisan db:seed

# Clear cache
docker-compose exec backend php artisan cache:clear
```

### Frontend Development

```bash
# Start dev server with hot reload
docker-compose exec frontend npm run dev

# Build for production
docker-compose exec frontend npm run build
```

### Testing

```bash
# Run backend tests
docker-compose exec backend php artisan test

# Run frontend tests
docker-compose exec frontend npm run test
```

---

## 📘 API Documentation

### 🧾 Orders API

- `GET /api/orders` – Paginated list of orders  
  **Query Parameters:**
  - `cursor`: ID to start from
  - `direction`: 'next' or 'prev'
  - `limit`: Items per page
  - `start_date`, `end_date`: Date filtering

- `GET /api/orders/{id}` – View a specific order

- `GET /api/analytics/sales` – Sales analytics  
  **Query Parameters:**
  - `start_date`, `end_date`: Date range

---

## 🗄 Database Configuration

Default `.env` database settings:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=pizza_sales
DB_USERNAME=pizza_user
DB_PASSWORD=password
```

Modify as needed in your `.env` file.

---

## 🤝 Contributing

1. Fork the repo
2. Create a new branch: `git checkout -b feature/amazing-feature`
3. Commit your changes: `git commit -m 'Add amazing feature'`
4. Push your branch: `git push origin feature/amazing-feature`
5. Open a Pull Request 🚀

---

## 🙌 Acknowledgments

- [Laravel](https://laravel.com) – Elegant PHP framework
- [Vue.js](https://vuejs.org) – Intuitive frontend framework
- [Tailwind CSS](https://tailwindcss.com) – Utility-first CSS
- Docker, MySQL, Nginx, and the open-source community ❤️
