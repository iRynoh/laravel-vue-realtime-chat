# Laravel Vue Realtime Chat 🚀

A real-time multi-room chat application built with Laravel, Vue.js, Inertia, and Pinia. Man, I want to eat a pineapple now...🍍

## ✨ Features

- 🏠 Multi-room chat system
- ⚡ Real-time messaging with Laravel Echo/Pusher
- 📜 Infinite scroll message loading
- 👥 Online user presence indicators
- ✍️ "User is typing" notifications 
- 🗄️ Message state management with Pinia

## 🛠️ Installation

1. Clone repository
```bash
git clone [repository-url]
cd [project-folder]
```

2. Install dependencies
```bash
composer install
npm install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Set up database in .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Set up Reverb credentials in .env (or keep the default configuration for local development)
```
REVERB_APP_ID=your_app_id  # Optional for local dev
REVERB_APP_KEY=your_app_key # Optional for local dev
REVERB_APP_SECRET=your_app_secret # Optional for local dev
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME=http
```

The default Reverb configuration works out of the box for local development, no additional setup needed.```

6. Run migrations and seeders
```bash
php artisan migrate:fresh --seed
```

7. Build assets
```bash
npm run dev
```

8. Start server
```bash
php artisan serve
```

## 👥 Demo Users

Log in with either of our friendly test users:

- 👨 John Doe
    - Email: john@example.com
    - Password: pass12345

- 👩 Jane Doe
    - Email: jane@example.com
    - Password: pass12345

Room #1 comes with a pre-seeded chat history between John and Jane - they've been having quite the conversation! 😄

## 🤝 Contributing

Feel free to open issues and pull requests! Let's make this chat app even more awesome together! 🌟

## 📝 License

MIT License. Chat away! 🎉
