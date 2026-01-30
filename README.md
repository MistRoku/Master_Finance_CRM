Master Finance CRM

A comprehensive, full-stack Customer Relationship Management (CRM) system designed for "Master Finance," a financial services company. Built with modern web technologies, it features secure user authentication, financial management tools, responsive UI with a professional red and black theme, and API support for future mobile app integration.
Features

    User Authentication & Role Management: Secure login with role-based access control (Admin, Accountant, User). Admins can manage users.
    Financial Management:
        Client portfolio management.
        Transaction tracking and history.
        Invoice generation and management.
        Financial reporting and analytics with interactive charts (via Chart.js).
        Budget planning and forecasting.
        Payment processing integration (ready for gateways like Stripe).
        Account reconciliation features.
    Database Architecture: MySQL-based with tables for users, clients, transactions, invoices, documents, and audit logs. Includes backup/recovery.
    User Interface: Responsive design (desktop, tablet, mobile) with semantic HTML5, red/black color scheme, and accessibility (WCAG guidelines).
    Security: SQL injection prevention, XSS protection, CSRF tokens, encrypted passwords, secure sessions, input validation.
    Additional Features:
        Search and filtering.
        Export to PDF/Excel.
        Email notifications (via PHPMailer).
        Activity logging and audit trails.
        Multi-language support (English prep, JSON-based).
        API endpoints for mobile integration.
    Performance: Fast load times, optimized queries, caching, scalable architecture.

Requirements

    Server: PHP 8+ with extensions (PDO, mbstring).
    Database: MySQL 5.7+ or PostgreSQL.
    Web Server: Apache/Nginx (with mod_rewrite) or built-in PHP server.
    Dependencies:
        Composer (for PHP packages).
        Node.js and npm (for TypeScript/Webpack).
        Libraries: Slim (routing), PHPMailer (emails), TCPDF/PhpSpreadsheet (exports), Chart.js (charts).
    Browser: Modern browsers (Chrome, Firefox, Safari) for full functionality.

Installation

    Clone the Repository:

    git clone https://github.com/your-repo/master-finance-crm.git
    cd master-finance-crm

    Install PHP Dependencies:

    composer install

    Install Node.js Dependencies:

    npm install

    Set Up the Database:
        Create a MySQL database (e.g., master_finance_crm).
        Run the SQL script in schema.sql to create tables.
        Add indexes for performance.

    Configure Environment:
        Copy config/.env.example to .env.
        Update with your DB credentials, SMTP settings, etc.:

        DB_HOST=localhost
        DB_NAME=master_finance_crm
        DB_USER=your_user
        DB_PASS=your_password
        SMTP_HOST=smtp.example.com
        SMTP_USER=your@email.com
        SMTP_PASS=your_password

    Build Frontend Assets:

    npm run build

    This compiles TypeScript and generates public/bundle.js.

    Start the Server:
        For development: php -S localhost:8000 -t public/.
        For production: Use Apache/Nginx with public/ as document root.

    Access the App:
        Open http://localhost:8000/login.
        Default admin: Create via SQL or register (role: admin).

Configuration

    Database: Update .env for connections.
    Email: Configure SMTP in .env for notifications.
    Languages: Add JSON files in config/languages/ (e.g., es.json for Spanish).
    Security: Ensure HTTPS in production; update CSRF/session settings in app/Core/Middleware.php.
    Caching: Enable APCu or Redis in app/Core/Cache.php for performance.

Usage

    Login: Use credentials based on role.
    Dashboard: View role-specific widgets and charts.
    Admin: Manage users, view analytics, backup DB.
    Accountant: Handle transactions, generate invoices, reconcile accounts.
    User: View personal data, upload documents, schedule appointments.
    Search/Filter: Use API or UI forms.
    Export: Download reports as PDF/Excel.
    API: Integrate with mobile apps (see below).

API Endpoints

RESTful API for mobile integration. All endpoints require authentication (CSRF token or future JWT).

    GET /api/transactions: Retrieve all transactions (JSON).
    GET /api/search?q={query}: Search transactions.
    GET /api/export?format=pdf|excel: Export transactions.
    POST /api/transactions: Add a transaction (JSON body).
    PUT /api/transactions/{id}: Update transaction.
    DELETE /api/transactions/{id}: Delete transaction.

Example (using cURL):

curl -X GET "http://localhost:8000/api/transactions" -H "X-CSRF-Token: your-token"

Full docs: Use Swagger UI with docs/api.yaml.
Testing

    Unit Tests: Run vendor/bin/phpunit (tests in tests/).
    Manual Testing: Test login, CRUD operations, exports.
    Browser Testing: Use tools like Selenium for UI.

Deployment

    Local/Dev: Use php -S or XAMPP.
    Production:
        Deploy to AWS EC2/RDS or similar.
        Use Docker: docker-compose up (see docker-compose.yml).
        Enable HTTPS (Let's Encrypt).
        Automate backups: mysqldump master_finance_crm > backup.sql.
        Monitor with New Relic or similar.
    Scaling: Add load balancers; optimize DB with read replicas.

Contributing

    Fork the repo.
    Create a feature branch: git checkout -b feature/new-feature.
    Commit changes: git commit -m "Add new feature".
    Push and create a PR.
    Follow PSR-12 for PHP, ESLint for JS.

License

MIT License. See LICENSE for details.
Support

For issues, open a GitHub issue or contact thabangmokgonyana@gmail.com. Version: 1.0.0.
