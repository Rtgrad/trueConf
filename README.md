1. Реализация RestApi для сущности user лежит в файле /App/routes/users.php

2. Описаны 5 запросов для сущности user
<br>
2.1 Получение списка user через GET /api/users
<br>
2.2 Получение user по id через GET /api/users/{id}
<br>
2.3 Добавление нового user через POST /api/users/add (Пример: /api/users/add?name=test1)
<br>
2.4 Удаление user по id через DELETE /api/users/delete/{id}
<br>
2.5 Изменение user по id через PUT /api/users/edit/{id} (Пример: /api/users/edit/0?name=test55)
<br>
3. Все данные хранятся в /App/jsonDB/users.json

4. Кроме полей которые были заявлен в тестовом задании , 
также были добавлены поля date_create,date_modify чтобы отследить время создания и обновления user

5. В /public/index.php производится просто подключение /App/routes/users.php и run()

6. Все запросы проверял через Postman