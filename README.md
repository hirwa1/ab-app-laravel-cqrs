```markdown
# AB 
## Setup Instructions

To get started with the project, follow these steps:

### 1. Clone the Project

```
git clone [project repository URL]
```

### 2. Install Dependencies or use Sail for Docker Option

Navigate to the project directory and run the following command to install the required dependencies using Composer:

```bash
composer install
```

Alternatively, if you prefer using Docker with Laravel Sail, make sure you have Docker and Docker Compose installed. Then, you can run the following commands to set up your environment:

```bash
# Copy the example environment file
cp .env.example .env

# Start Laravel Sail
./vendor/bin/sail up -d

# Install Composer dependencies using Sail
./vendor/bin/sail composer install
```

### 3. Database Migration

Run the following command to execute database migrations:

```bash
php artisan migrate
```

### 4. Configure Mail Driver

Choose one of the available mail drivers: `mailpti`, `smtp`, `maitrap`, or any other suitable driver for your needs. Configure the chosen mail driver in the project settings.

### 5. PDF Generator Setup

For PDF generation, this project utilizes `laravel-snappy`. Note that the default binary is set for Windows. Refer to the `laravel-snappy` documentation for platform-specific configurations.

### 6. Queue Configuration

Choose either the DB default or Redis for queue configuration. Both options are pre-configured. After selecting the desired queue configuration, run the following command to start the queue worker:

```bash
php artisan queue:work
```
```