# PHP Dotenv

Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automatically.

![Banner](https://raw.githubusercontent.com/lazervel/assets/main/banners/dotenv.png)

<p align="center">
<a href="https://github.com/shahzadamodassir"><img src="https://img.shields.io/badge/Author-Shahzada%20Modassir-%2344cc11?style=flat-square"/></a>
<a href="LICENSE"><img src="https://img.shields.io/github/license/lazervel/dotenv?style=flat-square"/></a>
<a href="https://packagist.org/packages/envs/dotenv"><img src="https://img.shields.io/packagist/dt/envs/dotenv.svg?style=flat-square" alt="Total Downloads"></img></a>
<a href="https://github.com/lazervel/dotenv/stargazers"><img src="https://img.shields.io/github/stars/lazervel/dotenv?style=flat-square"/></a>
<a href="https://github.com/lazervel/dotenv/releases"><img src="https://img.shields.io/github/release/lazervel/dotenv.svg?style=flat-square" alt="Latest Version"></img></a>
</p>

# Installation

Installation is super-easy via [Composer](https://getcomposer.org/)

```bash
composer require envs/dotenv
```

or add it by hand to your `composer.json` file.

## Usage

```php
use Dotenv\Dotenv;
require 'vendor/autoload.php';
```

If already .env file existing on current directory

```php
$dotenv = Dotenv::process(__DIR__);
$dotenv->load();
```

If already .env file existing on current directory without throwing error

```php
$dotenv = Dotenv::process(__DIR__);
$dotenv->safeLoad();
```

If already .env file existing on current directory

```php
$dotenv = Dotenv::process(__DIR__, 'myconfig.env');
$dotenv->load();
```

Loads multiple `.env` files.

```php
$dotenv = Dotenv::process(__DIR__, ['.env.local', '.env.example', '.env'], false);
$dotenv->load();
```

All of the defined variables are now available in the `$_ENV` and `$_SERVER` super-globals.

```php
$s3_bucket = $_ENV['S3_BUCKET'];
$s3_bucket = $_SERVER['S3_BUCKET'];
```

Nesting Variables
-----------------

It's possible to nest an environment variable within another, useful to cut down on repetition.

This is done by wrapping an existing environment variable in `${…}` e.g.

```php
BASE_DIR="/var/webroot/project-root"
CACHE_DIR="${BASE_DIR}/cache"
TMP_DIR="${BASE_DIR}/tmp"
```

Requiring Variables to be Set
-----------------------------

PHP dotenv has built in validation functionality, including for enforcing the presence of an environment variable. This is particularly useful to let people know any explicit required variables that your app will not work without.

You can use a single string:

```php
$dotenv->required('DATABASE_DSN');
```

Or an array of strings:

```php
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);
```

Security
--------

If you discover a security vulnerability within this package, please send an email to [shahzadamodassir@gmail.com](mailto:shahzadamodassir@gmail.com) All security vulnerabilities will be promptly addressed. You may view our full security policy [here](https://github.com/lazervel/dotenv/security/policy).

License
-------

PHP dotenv is licensed under [MIT License](https://github.com/lazervel/dotenv/blob/main/LICENSE).
