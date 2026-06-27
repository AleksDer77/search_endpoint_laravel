# Search Endpoint Laravel

Тестовое приложение на Laravel с эндпоинтом для фильтрации и сортировки продуктов.

## Запуск проекта

1. Установите зависимости:
```bash
composer install
npm install
```

2. Настройте окружение:
```bash
cp .env.example .env
php artisan key:generate
```

3. Запустите миграции и сидеры (при запросе на создание базы данных SQLite `database.sqlite` введите `yes`):
```bash
php artisan migrate --seed
```

4. Запустите сервер разработки и сборщик ассетов Vite:
```bash
php artisan serve
# в отдельном терминале:
npm run dev
```

## Использование API

Основной эндпоинт для работы с продуктами: `GET /api/products`

**Доступные параметры фильтрации:**
* `q` — поиск по названию продукта (LIKE)
* `category_id` — ID категории
* `in_stock` — наличие на складе (`1` или `0`)
* `price_from` / `price_to` — диапазон цен
* `rating_from` — минимальный рейтинг

**Сортировка:**
* `sort` — доступные значения: `price_asc`, `price_desc`, `rating_desc`, `newest` (по умолчанию)

## Тесты

Запуск всей тестовой базы:
```bash
php artisan test
```

Или по конкретным группам:
```bash
vendor/bin/phpunit tests/Unit   # только юнит-тесты
vendor/bin/phpunit tests/Feature # только интеграционные тесты
```

