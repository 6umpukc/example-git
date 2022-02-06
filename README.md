
# Порядок работы с проектом и примеры работы с GIT через командную PHP-строку Bitrix

- Примеры предназначены только **для случая** когда **нет возможности работать через SSH**

- Примеры запускаются через админку в разделе ["Командная PHP-строка"](https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=3055): /bitrix/admin/php_command_line.php

## Функция-обертка для запуска команд и форматированного вывода результата

```php
namespace sh; function x($cmd) { echo '<pre style="background-color:black;color:lightgreen;padding:12px 12px 12px 12px;margin:0px 0px;">' . '<b style="color:#fdff99;">' . "$ $cmd</b>\n"; system($cmd . ' 2>&1', $result); echo '<b style="color:white;">' . "exit code: $result</b></pre>"; }
```

### Примеры запуска команд

```php
chdir($_SERVER['DOCUMENT_ROOT']);
x('pwd');

x('ls -la');

x('whoami');
```

## Порядок работы с проектом (в общем)

1. Получить доступы к репозитарию для возможности создавать новые ветки и пушить изменения.

2. Изменения производятся через пулреквесты своей ветки в master или develop (прямые пуши в master / develop могут быть запрещены).

3. Проверить наличие .git на площадке (находится обычно в корне сайта), проверить в .git/config куда ссылается рабочая копия.

**Если .git отсутствует** - перейти к шагу [Настройка GIT на площадке](#настройка-git-на-площадке).

4. [Проверить состояние рабочей копии](#проверить-состояние-рабочей-копии) на тестовом / рабочем сайте.

5. Настроить/Актуализировать **свою локальную рабочую копию** и создать новую ветку от **develop** (если develop не используется - создать ветку от **master**).

Работы проводятся только на своей площадке (на локальном ПК сотрудника или созданой персонально для сотрудника на тестовом сервере). **!Тестовый сайт предназначен для предварительного показа результата клиенту а не для личных экспериментов**.

6. По итогу работ должен быть создан пулреквест в **develop** и **master**

7. Если есть конфликты слияния - они должны быть [разрешены](https://www.jetbrains.com/help/phpstorm/resolving-conflicts.html#distributed-version-control-systems). Для этого (и для визуальной работы с GIT в целом) удобно использовать IDE [PHPStorm](https://www.jetbrains.com/ru-ru/phpstorm/) или бесплатную [PyCharm Community](https://www.jetbrains.com/ru-ru/pycharm/).

8. Уведомить и дождатся когда сольют пулреквест в **develop** (или *master* если develop не используется), или сделать самостоятельно - если есть права.

9. [Применить изменения](#применить-изменения) на тестовом, убедится что изменения применены и передать на проверку.

10. После принятия работы по задаче на тестовом - уведомить и дождатся когда сольют пулреквест в **master**, или сделать самостоятельно - если есть права.

11. [Применить изменения](#применить-изменения) на рабочем сайте. Ветку по задаче лучше удалять только после слияния в мастер.

### Общие пункты при работе с GIT

- **Актуальное состояние на рабочем сайте** - рабочая копия должна быть переключена на ветку **master** и нет незакоммиченных изменений.

- **Актуальное состояние на тестовом сайте** - рабочая копия должна быть переключена на ветку **develop** (либо **master** если **develop** по какой то причине не существует в **репозитарии**) и нет незакоммиченных изменений.

- **Если переключено на другую ветку отличную от master, develop** - _уточнять состояние и порядок работ через чат или в задаче_.

- **Если видим ошибки при запуске команд git** - переходим к шагу [Настройка GIT на площадке](#настройка-git-на-площадке).

- **Если есть незакоммиченные изменения** - перейти к шагу [Актуализация рабочей копии](#актуализация-рабочей-копии).

- Корневая директория рабочей копии не всегда может располагаться в корне сайта - выяснить где реально расположена и заменить в примерах переход на директорию `chdir(путь к директории с .git);`

- **В любой непонятной ситуации** лучше _уточнять состояние и порядок работ через чат или в задаче_, т.к. на некоторых проектах может отличатся: названия и назначение веток, наличие многосайтовости, наличие автоматизации деплоя и т. д.

## Актуализация рабочей копии

1. Сохранить незакомиченные изменения во временную ветку.

```php
namespace sh; function x($cmd) { echo '<pre style="background-color:black;color:lightgreen;padding:12px 12px 12px 12px;margin:0px 0px;">' . '<b style="color:#fdff99;">' . "$ $cmd</b>\n"; system($cmd . ' 2>&1', $result); echo '<b style="color:white;">' . "exit code: $result</b></pre>"; }

chdir($_SERVER['DOCUMENT_ROOT']);

$currentDate = date('Y-m-d-H-i');
$tmpBranch = 'tmp-from-site-' . $currentDate;

x('git checkout -b ' . $tmpBranch);
x('git add .');
x('git commit -am ' . $tmpBranch);
x('git push --set-upstream origin ' . $tmpBranch);
```

2. Cоздать пулреквест и смержить в master / develop (в зависимости от сайта)

3. Переключить ветку на master / develop (в зависимости от сайта)

4. [Применить изменения](#применить-изменения)

## Настройка GIT на площадке

**Директория с ключами может отличатся от ~/.ssh/** - если это так, то поменять путь в сниппетах

### Проверить наличие ключа

```php
namespace sh; function x($cmd) { echo '<pre style="background-color:black;color:lightgreen;padding:12px 12px 12px 12px;margin:0px 0px;">' . '<b style="color:#fdff99;">' . "$ $cmd</b>\n"; system($cmd . ' 2>&1', $result); echo '<b style="color:white;">' . "exit code: $result</b></pre>"; }

chdir($_SERVER['HOME'] . '/.ssh/'); // !подставлять реальный путь к директории с ключами

x('ls id_rsa*');
```

### Если ключа нет на площадке - создать его

```php
namespace sh; function x($cmd) { echo '<pre style="background-color:black;color:lightgreen;padding:12px 12px 12px 12px;margin:0px 0px;">' . '<b style="color:#fdff99;">' . "$ $cmd</b>\n"; system($cmd . ' 2>&1', $result); echo '<b style="color:white;">' . "exit code: $result</b></pre>"; }

chdir($_SERVER['DOCUMENT_ROOT']);

x("ssh-keygen -t rsa -C 'somesite@example.org' -N '' -f ~/.ssh/id_rsa");
``` 

### Скачать файл публичного ключа `~/.ssh/id_rsa.pub` и добавить в настройках репозитария (или попросить чтоб добавили если нет прав)

### После клонирования выполнить

```php
namespace sh; function x($cmd) { echo '<pre style="background-color:black;color:lightgreen;padding:12px 12px 12px 12px;margin:0px 0px;">' . '<b style="color:#fdff99;">' . "$ $cmd</b>\n"; system($cmd . ' 2>&1', $result); echo '<b style="color:white;">' . "exit code: $result</b></pre>"; }

chdir($_SERVER['DOCUMENT_ROOT']);

x('git config user.email "somesite@example.org"');
x('git config user.name "Some Site"');
x('git config push.default simple');
x('git config core.filemode false');
```

### **Если есть ошибки авторизации по ключу** при клонировании репозитария (или pull/push и т. д.) - добавить в `~/.ssh/config`

```
Host *
  StrictHostKeyChecking no
  UserKnownHostsFile=/dev/null
```

### Если репозитарий использует нестандартный порт и этот порт на хостинге заблокирован 

- попробовать заменить порт в урл репозитария на **3306**

### Продебажить соединение по ssh к репозитарию

```bash
ssh -v -T git@yourgithub.com -p 3306
```

## Применить изменения

- применить изменения по коду

```php
namespace sh; function x($cmd) { echo '<pre style="background-color:black;color:lightgreen;padding:12px 12px 12px 12px;margin:0px 0px;">' . '<b style="color:#fdff99;">' . "$ $cmd</b>\n"; system($cmd . ' 2>&1', $result); echo '<b style="color:white;">' . "exit code: $result</b></pre>"; }

chdir($_SERVER['DOCUMENT_ROOT']);

x('git pull');
```

- применить миграции (если используются) или применить описанные действия с БД по задаче (если такие имеются)

## Проверить состояние рабочей копии

```php
namespace sh; function x($cmd) { echo '<pre style="background-color:black;color:lightgreen;padding:12px 12px 12px 12px;margin:0px 0px;">' . '<b style="color:#fdff99;">' . "$ $cmd</b>\n"; system($cmd . ' 2>&1', $result); echo '<b style="color:white;">' . "exit code: $result</b></pre>"; }

chdir($_SERVER['DOCUMENT_ROOT']);
x('pwd');

x('git branch');
x('git status');

// просмотр удаленного репозитория
x('git remote show origin');
```
