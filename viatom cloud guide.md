# Viatom Cloud Guide

# Server

## Server Requirement

Homestead or 

- PHP version >= 5.5.9
- PHP extension:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer

## Install Laravel

Laravel utilizes [Composer](http://getcomposer.org/) to manage its dependencies. Make sure you have Laravel Installed.

### Via Laravel Installer

```basic
composer global require "laravel/installer"
laravel new blog
```

### Via Composer Create-Project

```basic
composer create-project laravel/laravel {directory} 4.2 --prefer-dist blog
```

## Configuration

*TODO*

- ```storage``` and ```bootstrap/cache``` directory should be writable

## Maintenance Mode

To enable maintenance mode, simply execute the `down` Artisan command:

```
php artisan down
```

To disable maintenance mode, use the `up` command:

```
php artisan up
```

