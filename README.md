![alt text](https://marshmallow.dev/cdn/media/logo-red-237x46.png "marshmallow.")

# Laravel Redirectable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marshmallow/redirectable.svg?style=flat-square)](https://packagist.org/packages/marshmallow/redirectable)
[![Tests](https://img.shields.io/github/actions/workflow/status/marshmallow-packages/redirectable/php-syntax-checker.yml?branch=main&label=tests&style=flat-square)](https://github.com/marshmallow-packages/redirectable/actions/workflows/php-syntax-checker.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/marshmallow/redirectable.svg?style=flat-square)](https://packagist.org/packages/marshmallow/redirectable)

Store redirects via Nova and load them in your routes.

Redirectable lets you manage HTTP redirects from a [Laravel Nova](https://nova.laravel.com) resource and serve them as real, cacheable routes. Redirects can be standalone or attached (polymorphically) to any Eloquent model — for example a page resource — so that when a model's slug changes, its old URLs keep pointing at the right place.

## Installation

Install the package via Composer:

```bash
composer require marshmallow/redirectable
```

The service provider is auto-discovered and the package migrations are loaded automatically. Run them with:

```bash
php artisan migrate
```

This creates the `redirects` table.

Optionally publish the config file:

```bash
php artisan vendor:publish --provider="Marshmallow\Redirectable\RedirectableServiceProvider"
```

## Configuration

The published `config/redirectable.php` exposes the following keys:

| Key | Default | Description |
| --- | --- | --- |
| `database.connection` | `null` | Database connection used when checking whether redirect routes should be loaded. `null` uses the default connection. |
| `models.redirect` | `Marshmallow\Redirectable\Models\Redirect::class` | The Eloquent model used to store and resolve redirects. Override to use your own model. |
| `types` | `[Marshmallow\Pages\Nova\Page::class]` | Nova resources that may be associated with a redirect via the `MorphTo` field. |
| `http_codes` | `[301 => '301 Moved Permanently']` | The HTTP status codes selectable in Nova when creating a redirect. |

## Usage

### Register the redirect routes

Call `Redirector::routes()` in your `routes/web.php` so the stored redirects are registered as routes. They are added last, never overriding existing application routes, and can be route-cached:

```php
use Marshmallow\Redirectable\Facades\Redirector;

// routes/web.php — register this after your own routes
Redirector::routes();
```

When a registered redirect URL is hit, the package resolves the final destination (following chained redirects) and returns a redirect response with the configured HTTP code.

### Manage redirects in Nova

Register the bundled Nova resource in your `NovaServiceProvider`:

```php
use Marshmallow\Redirectable\Nova\Redirect;

protected function resources(): void
{
    Nova::resources([
        Redirect::class,
    ]);
}
```

The resource appears under the **SEO** group and lets you set the source path (`redirect this`), the destination (`to this`), the HTTP code, and an optional associated resource.

### Attach redirects to a model

Add the `Redirectable` trait to any model you want to attach redirects to. It provides a `redirectable()` morph-many relation:

```php
use Illuminate\Database\Eloquent\Model;
use Marshmallow\Redirectable\Traits\Redirectable;

class Page extends Model
{
    use Redirectable;
}
```

You can then create redirects for that model through the `Redirector` facade. `add()` records a redirect, removes redirects made obsolete by the new destination, and re-points existing trailing redirects to the new destination:

```php
use Marshmallow\Redirectable\Facades\Redirector;

Redirector::add($page, '/old-url', '/new-url');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see the Marshmallow packages contribution process for details. Pull requests are welcome.

## Security Vulnerabilities

If you discover any security related issues, please email stef@marshmallow.dev instead of using the issue tracker.

## Credits

- [Stef van Esch](https://github.com/marshmallow-packages)
- [All Contributors](https://github.com/marshmallow-packages/redirectable/contributors)

## License

The MIT License (MIT). Please see the [License File](LICENSE.md) for more information.
