![Header](.github/header.jpg)

# Laravel DB Vault

A simple Laravel package that allows you to store and retrieve environment variables in a database. It supports optional
encryption for additional security.

## Installation

```bash
composer install zappzerapp/laravel-db-vault
```

## Usage

### Retrieve values

Use the `vault(string $context, string $key, mixed $default = null)` helper to retrieve values from the database:

```php
$imageSize = vault('user', 'image_size', '1280x720');
```

### Save values

Use the `vault_set(string $context, string $key, mixed $value, bool $encrypted = false)` helper to store values in the database:

To save an unencrypted value:

```php
vault_set('user', 'image_size', '1337x420');
```

To save an encrypted value:

```php
vault_set('aws', 'api_key', 'secret_api_key', true);
```

## Encryption

The stored values can be protected with the encryption option. If the parameter `$encrypt`
parameter is set to `true`, the value is encrypted before being saved. The `vault()` helper decrypts the value
automatically when it is retrieved.

## Licence

This project is licensed under the MIT licence. See the [LICENSE](LICENSE) file for details.
