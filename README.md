
**Сокет-сервер для проверки скобок.**

**Установка**

`composer install `

**Запуск docker контейнера**

`docker-compose up -d`

**Войти в docker контейнер**

`docker exec -ti socker-server bash`

**Проверить правильность расстановки скобок**

`php bin/client.php`