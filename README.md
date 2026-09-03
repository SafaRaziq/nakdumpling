# CakePHP Application Skeleton

![Build Status](https://github.com/cakephp/app/actions/workflows/ci.yml/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%207-brightgreen.svg?style=flat-square)](https://github.com/phpstan/phpstan)

A Nak Dumpling Ordering System

Family-business food ordering system built with CakePHP 5.x and PHP 8.1+.

## Planned workflows

- Customers browse the menu, add items to a cart, submit an order, and review recent orders.
- Customers provide delivery details, a map pin, and an optional house photo for delivery.
- Admins manage menu items, see incoming orders, and update order status from received to preparing, ready, out for delivery, and completed.
- Kitchen staff use a focused preparation queue that can be printed cleanly on A4 paper.
- Customers can leave a rating and review after an order is completed.

## Initial roles

- `customer`: menu, cart, checkout, order history, location details, and reviews.
- `staff`: kitchen preparation queue and status updates.
- `admin`: staff access plus menu, orders, users, and review moderation.

## Core data model

The first database migration should define `users`, `menu_items`, `orders`, `order_items`, `delivery_locations`, `reviews`, and `order_status_history`. Orders store a snapshot of item names and prices through `order_items`, so historical receipts remain correct when the menu changes. Delivery latitude, longitude, address notes, and house-photo path belong to `delivery_locations` rather than the user profile.

## Local setup

1. Copy `config/app_local.example.php` to `config/app_local.php` if it does not exist.
2. Configure the MySQL/MariaDB connection in `config/app_local.php`.
3. Create the database, then run migrations when they are added:

```bash
bin/cake migrations migrate
```

4. Start the development server:

```bash
bin/cake server -p 8765
```

Open `http://localhost:8765`.

## Development checks

```bash
php vendor/bin/phpunit --colors=never
```

The kitchen print view should use a dedicated print stylesheet with `@page { size: A4; margin: 12mm; }`, hide navigation and controls, and keep each order together where possible. Uploaded house photos should be validated by MIME type and size, stored outside the public web root when possible, and served only to authorized staff handling that order.

Menu photos are optional. The `menu_items.image` column stores a relative web path such as `menu/set-soup.jpg`; once an admin uploads or copies a photo to `webroot/img/menu/`, the menu card displays it automatically. Cards show a branded placeholder until a photo is provided.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration

Read and edit the environment specific `config/app_local.php` and set up the
`'Datasources'` and any other configuration relevant for your application.
Other environment agnostic settings can be changed in `config/app.php`.

## Layout

The app skeleton uses [Milligram](https://milligram.io/) (v1.3) minimalist CSS
framework by default. You can, however, replace it with any other library or
custom styles.
