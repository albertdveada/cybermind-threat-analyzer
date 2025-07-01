<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 🚀 About The Project
CyberMind Threat Analyzer is a Laravel-based backend API that uses **Artificial Intelligence (AI)** to automatically detect, analyze, and monitor potential security threats.
Designed as an initial experiment in **integrating AI with log and activity security systems**, this project can be further developed into a smarter and more responsive cybersecurity solution.


## 🔧 Technologies & Core Components

- **Backend:** [Laravel](https://laravel.com/) — The core PHP framework for backend logic, routing, and database management.
- **Authentication:** [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze) — Lightweight starter kit for authentication.
- **Database:** [MySQL](https://www.mysql.com/) — Relational database management system.
- **AI & Analysis Engine:** Powered by [*Google's Gemini*](https://ai.google.dev/gemini-api/docs) to analyze security logs and identify sophisticated threat patterns.
- **Custom Packages:** Customized implementations of *Spatie* packages for enhanced backend functionality.
- **Frontend:**
    - [Tailwind CSS](https://tailwindcss.com/) — Utility-first CSS framework for modern and responsive design.
    - [Alpine.js](https://alpinejs.dev/) — Lightweight JavaScript framework for frontend interactivity.

## 🚀 Features

- **AI-Powered Log Analysis:**
    - Provides secure **API endpoints** for receiving system or firewall logs.
    - The **AI engine analyzes** these logs to identify indicators of potential threats, such as brute-force attacks, unauthorized access attempts, and other suspicious activities.
- **Threat Level Classification:**
    - After analysis, the system automatically assigns a threat level to each event: **None, Low, Medium, High, or Critical.**
    - This classification helps prioritize responses and focus on the most significant threats.
- **Secure API Architecture:**
    - **API Key Authentication:** Endpoints are protected by custom middleware ``(public.key)`` to ensure that only authorized systems can submit logs for analysis.
    - **Standardized JSON Responses:**  Implements custom exception handling to provide clear, consistent ``JSON`` error responses for common issues like validation failures ``(422)`` and authentication errors ``(401)``.
- **Live Threat Dashboard:**
    - The homepage features a real-time dashboard displaying key statistics and visualizations of ongoing security events.
    - Allows for direct monitoring of the system's security posture at a glance.
- **Standard User Management:**
    - Includes complete user authentication features (login, register, logout) managed by Laravel Breeze.

## ⚡ API Endpoints
Complete API documentation, including all available endpoints, request formats, and example responses, is available to view and test via Postman.
Click the button to view: [[Postman Documentation CyberMind Threat Analyzer](https://www.postman.com/albertdveada/my-experiments-api/collection/gh0a8z1/cybermind-threat-analyzer-api)]


## 📦 Installation Guide
This guide is for setting up the project in a local environment.

1. **Get the Project Code 📂**
   ```bash
   git clone https://github.com/albertdevada/cybermind-threat-analyzer.git
   cd cybermind-threat-analyzer
    ```
2. **Setup Configuration & Dependencies**
   ```bash
   cp .env.example .env
   composer install
   npm install
    ```
4. **Configure Your Environment (``.env``)**
    This file holds all your project's sensitive credentials. Open the ``.env`` file and configure the following:
    - **Database Credentials**
    Update variables ``(DB_DATABASE, DB_USERNAME, DB_PASSWORD)`` with your local database details.
    - **AI API Key (Google Gemini)**
    1 . Visit [Google AI Studio.](https://ai.google.dev)
    2 . Log in with your Google account and click on **"Get API key".**
    3 . Copy the generated key and paste it into your ``.env`` file:
   ```env
    AI_API_KEY=your_gemini_api_key_here
    ```
4. **Finalize Installation**
    Now, run the following commands to generate the application key and set up the database with its initial data:
   ```bash
   php artisan key:generate
   php artisan migrate --seed
    ```
5. **Run the Development Servers**
    You need to open two separate terminals to run the servers.
    - **Terminal (Backend):**
   ```bash
    php artisan serve
    ```
    - **Terminal (Frontend):**
   ```bash
    npm run dev
    ```
6. **Access the Application**
    Done! Open your browser and visit the following address:
   - 🔗 [ Open PHP App (localhost:8080) ](http://localhost:8080)  
   - 🔗 [ Open phpMyAdmin (localhost:8181) ](http://localhost:8181)

---
#### ⚙️ Custom Commands
After the installation is complete, you can use the following custom command to quickly create a new user from your terminal. This is useful for testing or adding new users without using the web interface.
- **Custom Commands**
   ```bash
    php artisan user:create "New User Name" "newuser@example.com"
    ```
---
## 🙌 Contribution
This project is open for contributions! Feel free to fork and submit a pull request if you'd like to add new features or fix any issues.
Built with passion for learning and growing. Enjoy! 🚀

## 📜 License
Distributed under the MIT License. See ``LICENSE.txt`` for more information.

---

<p align="center">
  <b>© Create by Albert Devada. Built with 💻 and ☕. All rights reserved.</b>
</p>