# ToDoList App

A task management web application built with **Laravel** framework as part of the **Application Development and Emerging Technologies** course.

## 📋 Project Overview

ToDoList App is a simple yet functional web application that allows users to create, manage, and organize their daily tasks and to-do items. The application provides a clean interface for adding, editing, marking as complete, and deleting tasks.

<img width="1363" height="644" alt="image" src="https://github.com/user-attachments/assets/b4b53f7b-a4ec-4d95-bf6e-5bd015378d96" />

<img width="1313" height="630" alt="image" src="https://github.com/user-attachments/assets/2e2df62f-6d10-4803-a70b-221d99e26dde" />

<img width="1356" height="627" alt="image" src="https://github.com/user-attachments/assets/1e59def9-2f9e-4892-8d85-6d262af72f16" />



## 🎯 Features

- ✅ **Create Tasks** - Add new to-do items to your list
- ✏️ **Edit Tasks** - Update existing task details
- ✔️ **Mark as Complete** - Check off completed tasks
- 🗑️ **Delete Tasks** - Remove tasks from your list
- 📱 **Responsive Design** - Works on desktop, tablet, and mobile devices
- 💾 **Persistent Storage** - Tasks are saved in a database

## 🛠️ Technology Stack

### Backend
- **Laravel** - PHP web application framework
- **PHP** - Server-side language
- **MySQL/SQLite** - Database management

### Frontend
- **Blade Templates** - Laravel's templating engine
- **HTML5 & CSS3** - Markup and styling
- **JavaScript** - Client-side interactivity
- **Vite** - Frontend build tool

### Development Tools
- **Composer** - PHP dependency manager
- **npm/Yarn** - JavaScript package manager
- **PHPUnit** - Testing framework

## 📁 Project Structure

```
ToDoList-App/
├── app/                    # Application code (Models, Controllers, etc.)
├── bootstrap/              # Bootstrap application files
├── config/                 # Configuration files
├── database/               # Database migrations and seeders
├── public/                 # Publicly accessible files (images, CSS, JS)
├── resources/              # Views, language files, and assets
├── routes/                 # API and web route definitions
├── storage/                # Logs, cache, and uploads
├── tests/                  # Unit and feature tests
├── composer.json           # PHP dependencies
├── package.json            # JavaScript dependencies
├── vite.config.js          # Vite configuration
└── .env.example            # Environment variables template
```

## 🚀 Getting Started

### Prerequisites

Before you begin, ensure you have the following installed on your system:
- **PHP** (8.0 or higher)
- **Composer**
- **Node.js** (14 or higher)
- **npm** or **Yarn**
- **MySQL** or **SQLite**

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/JLNerecina/ToDoList-App.git
   cd ToDoList-App
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies:**
   ```bash
   npm install
   # or if using Yarn
   yarn install
   ```

4. **Create environment file:**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

6. **Configure your database:**
   - Open `.env` file
   - Update `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` according to your database setup

7. **Run database migrations:**
   ```bash
   php artisan migrate
   ```

8. **Build frontend assets:**
   ```bash
   npm run build
   # or for development with hot reload
   npm run dev
   ```

9. **Start the development server:**
   ```bash
   php artisan serve
   ```

   The application will be available at `http://localhost:8000`

## 📝 Usage

### Running the Application

1. **Development Mode (with hot reload):**
   ```bash
   # Terminal 1: Start Laravel server
   php artisan serve
   
   # Terminal 2: Start Vite development server
   npm run dev
   ```

2. **Production Build:**
   ```bash
   npm run build
   php artisan serve
   ```

### Managing Tasks

1. **View Tasks** - Open the application and see your task list
2. **Add a Task** - Click "Add Task" and enter your task details
3. **Mark Complete** - Click the checkbox next to a task to mark it as done
4. **Edit a Task** - Click the edit button to modify task details
5. **Delete a Task** - Click the delete button to remove a task from your list

## 🧪 Testing

Run the test suite using PHPUnit:

```bash
php artisan test
```

For more detailed test output:
```bash
php artisan test --verbose
```

## 📚 Available Commands

```bash
# Migrate the database
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Refresh the database
php artisan migrate:refresh

# Seed the database
php artisan db:seed

# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# View all available routes
php artisan route:list
```

## 📖 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Best Practices](https://laravel.com/docs/contributions)
- [Laracasts - Video Tutorials](https://laracasts.com)
- [Laravel Learn](https://laravel.com/learn)

## 🤝 Contributing

Contributions are welcome! To contribute:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the **MIT License**. See the `LICENSE` file for details.

## 👤 Author

**JLNerecina**
- GitHub: [@JLNerecina](https://github.com/JLNerecina)

## 📧 Support

For questions or issues, please:
- Open an [issue on GitHub](https://github.com/JLNerecina/ToDoList-App/issues)
- Contact the project maintainer

## 🎓 Course Information

This project is developed as an educational activity for:
- **Course:** Application Development and Emerging Technologies
- **Topic:** Web Application Development with Modern Frameworks

## 🔗 Useful Links

- [GitHub Repository](https://github.com/JLNerecina/ToDoList-App)
- [Laravel Framework](https://laravel.com)
- [Vite Build Tool](https://vitejs.dev)

---

**Last Updated:** 2026

**Version:** 1.0.0

Happy task managing! 📝✨
