# Каталог товаров - API

## Запуск проекта

1. **Клонировать репозиторий**:
   ```bash
   git clone https://github.com/Dmitriy-gitt/laravel-product-catalog.git
   cd laravel-product-catalog
   ```

2. **Настроить окружение**:
    - Создать файл `.env` (на основе `.env.example`)
    - Проверить настройки БД в `.env`:
      ```
      DB_CONNECTION=mysql
      DB_HOST=db
      DB_PORT=3306
      DB_DATABASE=laravel
      DB_USERNAME=laravel
      DB_PASSWORD=secret
      ```

3. **Запустить контейнеры**:
   ```bash
   docker-compose up -d --build
   ```

4. **Установить зависимости**:
   ```bash
   docker-compose exec app composer install
   ```

5. **Запустить миграции и сидеры**:
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

## Доступ к сервисам

- **API**: http://localhost/api/products
- **PHPMyAdmin**: http://localhost:8080
    - Логин: `root`
    - Пароль: `secret`

## Примеры запросов

1. Получить все товары:
   ```bash
   GET /api/products
   ```

2. Фильтр по свойствам:
   ```bash
   GET /api/products?properties[Бренд][]=Xiaomi&properties[Цвет][]=Черный
   ```

3. Пагинация:
   ```bash
   GET /api/products?page=2
   ```

## Структура ответа
```json
{
  "data": [
    {
      "id": 1,
      "name": "Товар 1",
      "price": 100.50,
      "properties": [
        {
          "name": "Бренд",
          "value": "Xiaomi"
        }
      ]
    }
  ],
  "links": {
    "first": "...",
    "last": "..."
  }
}
```

## Остановка проекта
```bash
docker-compose down
```
