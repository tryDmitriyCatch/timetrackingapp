# Timetracking App

Timetracking App is a Symfony/React app for managing various tasks

## Prerequisites

This project requires to have PHP 7.4 installed

## Installation

### Clone this repo

```bash
git clone https://github.com/tryDmitriyCatch/timetrackingapp.git
```

### CD into timetracker

### Fill in your local MySQL environment variables:

```bash
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/timetracker?serverVersion=mariadb-10.4.11
```

### Install all dependencies with Composer

```bash
composer update
```

### Create Database with timetracker name with your MySQL client

### Run migrations

```bash
bin/console doctrine:migration:migrate
```

### Run User fixture

```bash
bin/console doctrine:fixtures:load
```

### Install front end dependencies
```bash
yarn install
```

### Run local symfony server
```bash
bin/console server:start
```

### Compile front end assets
```bash
yarn watch --dev
```

### P.S

Make sure that your local url matches one in .env-front file

### Enjoy!

## Usage

Since we ran our fixtures command, there are couple of users available for us.

User: user2@test.com
Password: test
