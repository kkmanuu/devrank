# DevRank

DevRank is a Laravel-based platform designed to bridge the gap between academic developers and real-world experience. Built with a local database on XAMPP, it connects students, coaches, and administrators through project reviews, coaching sessions, and career-launching opportunities, transforming potential into proven skills.

## Features

### For Students
- **User Authentication & Profile Management**: Securely register, log in, and manage personal profiles.
- **Project Submission**: Submit projects for review and feedback.
- **Coaching Sessions**: Book and participate in one-on-one or group coaching sessions.
- **Event Participation**: Browse and register for career-focused events.
- **Notifications**: Stay updated with real-time notifications for project reviews, events, and messages.
- **Payment Integration**: Make secure payments for coaching and events via M-PESA.
- **Contact Support**: Send messages to administrators for assistance.

### For Coaches
- **Session Management**: Create, edit, and manage coaching sessions.
- **Project Reviews**: Provide detailed feedback on student project submissions.
- **Event Hosting**: Organize and manage career-focused events.

### For Administrators
- **User Management**: Create, view, and manage user accounts (students and coaches).
- **Submission Oversight**: Review, edit, or delete project submissions.
- **Event & Coaching Management**: Create, update, or remove events and coaching sessions.
- **Service Management**: Add, edit, or delete platform services.
- **Contact Message Handling**: View, reply to, and manage user inquiries.
- **Payment Monitoring**: Track payment statuses and transaction details.

## Tech Stack

| Layer          | Technology              |
| -------------- | ----------------------- |
| Framework      | Laravel                 |
| Database       | MySQL (via XAMPP)       |
| Frontend       | Blade, Bootstrap        |
| Authentication | Laravel Authentication  |
| Payment        | M-PESA API Integration  |
| Localization   | Multi-language support (English, Swahili) |


## Project Structure

```
devrank/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Route controllers
│   │   ├── Middleware/        # Authentication & role-based middleware
│   ├── Models/                # Eloquent models
├── config/                    # Configuration files
├── database/                  # Migrations, seeders
├── public/                    # Static assets (CSS, JS, images)
├── resources/
│   ├── lang/                  # Language files for localization
│   ├── views/                 # Blade templates
├── routes/
│   ├── web.php                # Web routes
│   ├── auth.php               # Authentication routes
├── .env.example               # Environment configuration template
└── README.md                  # Project documentation
```


## Getting Started

### Prerequisites
- PHP (v8.0 or higher)
- Composer
- XAMPP (with MySQL)
- Node.js (for frontend assets)
- M-PESA API credentials (for payment integration)

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/kkmanuu/devrank
cd devrank

3. Install backend dependencies
```bash
composer install
```

4. Create a `.env` file in the server directory with the following variables:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=devrank
DB_USERNAME=root
DB_PASSWORD=

MPESA_CONSUMER_KEY=your_consumer_key
MPESA_CONSUMER_SECRET=your_consumer_secret
MPESA_SHORTCODE=your_shortcode
MPESA_PASSKEY=your_passkey
```

### 5. Start the Development Server

Run database migrations:

```bash
php artisan migrate




```


### 6. Start the Laravel development server:
```bash
php artisan serve
```


## API Endpoints

Below is the complete list of available API routes for the application.

---

### **Public Routes**
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET    | `/` | Home page |
| GET    | `/about` | About page |
| GET    | `/services` | Services page |
| GET    | `/contact` | Contact page |
| POST   | `/contact` | Submit contact message |
| GET    | `/set-locale/{locale}` | Switch language (English/Swahili) |

---

### **Authenticated Routes**
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET    | `/dashboard` | User dashboard |
| GET    | `/profile/edit` | Edit user profile |
| GET    | `/profile/show` | View user profile |
| PATCH  | `/profile` | Update profile |
| DELETE | `/profile` | Delete account |
| GET    | `/submit-project` | Project submission form |
| POST   | `/submit-project` | Submit project |
| GET    | `/submissions/{submission}` | View submission details |
| GET    | `/events` | List events |
| GET    | `/events/{event}` | View event details |
| POST   | `/events/{event}/book` | Book event |
| GET    | `/coaching` | List coaching sessions |
| GET    | `/coaching/{session}` | View session details |
| POST   | `/coaching/{session}/book` | Book coaching session |
| GET/POST | `/payment` | Initiate payment |
| GET    | `/payment/status/{payment}` | Check payment status |
| GET    | `/notifications` | List notifications |
| PATCH  | `/notifications/{notification}/mark-as-read` | Mark notification as read |

---

### **Admin Routes** *(prefix: `/admin`)*
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET    | `/dashboard` | Admin dashboard |
| GET    | `/users` | List users |
| POST   | `/users` | Create user |
| GET    | `/submissions` | List submissions |
| POST   | `/submissions/{submission}/review` | Review submission |
| GET    | `/payments` | List payments |
| GET    | `/events` | List events |
| POST   | `/events` | Create event |
| PUT    | `/events/{event}` | Update event |
| DELETE | `/events/{event}` | Delete event |
| GET    | `/coaching` | List coaching sessions |
| POST   | `/coaching` | Create coaching session |
| PUT    | `/coaching/{session}` | Update coaching session |
| DELETE | `/coaching/{session}` | Delete coaching session |
| GET    | `/services` | List services |
| POST   | `/services` | Create service |
| PUT    | `/services/{service}` | Update service |
| DELETE | `/services/{service}` | Delete service |
| GET    | `/contact-messages` | List contact messages |
| POST   | `/contact-messages/{contactMessage}/reply` | Reply to message |
| PATCH  | `/contact-messages/{contactMessage}/mark-as-read` | Mark message as read |
| DELETE | `/contact-messages/{contactMessage}` | Delete message |

---

### **M-PESA Routes**
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST   | `/mpesa/callback` | M-PESA callback |
| POST   | `/mpesa/validate` | Validate M-PESA transaction |
| POST   | `/mpesa/confirm` | Confirm M-PESA transaction |
| POST   | `/mpesa/stk-push` | Initiate STK push |
| POST   | `/mpesa/transaction-status` | Check transaction status |



## : Authors <a name="authors"></a>
- *Emmanuel Kipngeno*
- GitHub: [@githubhandle](https://github.com/kkmanuu)
- Twitter: [@twitterhandle](https://twitter.com/kkmanuu)
- LinkedIn: [LinkedIn](https://www.linkedin.com/in/emmanuel-kipngeno/)
## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is [MIT](./LICENSE.md) licensed.
<p align="right">(<a href="#readme-top">back to top</a>)</p>