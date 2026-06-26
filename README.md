# Search Endpoint Laravel

## Запуск проекта

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Тесты

```bash
php artisan test
```

```bash
php artisan test --filter=ProductFilterTest
php artisan test --filter=ProductsIndexEndpointTest
```
