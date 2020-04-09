# Тестовое задание

1. Скопировать .env.example в .env
2. Установить пароль к БД в `.env` файле `DB_PASSWORD` 
3. Запустить контейнеры `docker-compose up -d`
4. Установить зависимости проекта `docker exec -it app composer install`
5. Выполнить миграции `docker exec -it app src/protected/yiic migrate`
6. Сконфигурировать путь и шаблон к лог файлам в `config/console.php`
    ```php
        'commandMap' => [
            'import' => [
                'class' => 'application.commands.ImportCommand',
                'path' => '/var/www/log/',
                'pattern' => '/^access[0-9]{0,4}\.log$/i'
            ]
        ]
    ```
   Путь указывается относительно контейнера. По-умолчанию парсит собственный `access.log`. 
   Внешнюю папку нужно предварительно примонтировать в `docker-compose.yml` к контейнеру `app`.

6. Загрузить данные в БД `docker exec -it app src/protected/yiic import`
7. Посетить http://127.0.0.1/
