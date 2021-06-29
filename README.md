# Задача

> Создать проект, на главной странице находится баннер <img src=”banner.jpg”/> и ссылка для входа в личный кабинет с авторизацией логин-пароль, либо через соцсети, на ваше усмотрение. В личном кабинете создать каталог книг и авторов (названия книги и имени автора достаточно) с возможностью добавления и удаления новых записей. Также в ЛК присутствует счетчик который обновляет данные по просмотрам баннера раз в 26 секунд и показывает, собственно, количество просмотров и время последнего обновления данных.
Добавьте docker-compose.yml.

# Установка и настройка окружения

Для Debian & Ubuntu.

### Обновление системы

**Выполнить с root правами.**

```
apt-get update \
    && apt-get upgrade \
    && apt-get install make libssl-dev libghc-zlib-dev libcurl4-gnutls-dev libexpat1-dev gettext unzip apt-transport-https ca-certificates curl gnupg2 software-properties-common make libcurl4-gnutls-dev gcc libssl-dev expat libexpat1-dev gettext wget
```

### Установка Docker

**Выполнить с root правами.**

```
curl -fsSL https://download.docker.com/linux/debian/gpg | gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg \
    && echo \
"deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/debian \
$(lsb_release -cs) stable" | tee /etc/apt/sources.list.d/docker.list > /dev/null \
    && apt-get update \
    && apt-get install docker-ce docker-ce-cli containerd.io
```

Добавить рабочего пользователя в группу докера:

`sudo usermod -aG docker ${USER}`

Перезапустить сеанса рабочего пользователя.

Тест:

`docker version`

Тест из-под рабочего пользователя:

`docker ps`

На основе [инструкции](https://docs.docker.com/engine/install/debian/#install-using-the-repository).

### Установка Docker Compose

**Выполнить с root правами.**

Узнать актуальную версию в [исходниках](https://github.com/docker/compose/releases).

```
export dockerComposeVersion=<версия>

curl -L "https://github.com/docker/compose/releases/download/${dockerComposeVersion}/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose \
    && chmod +x /usr/local/bin/docker-compose
```

Тест:

`docker-compose version`

На основе [инструкции](https://docs.docker.com/compose/install/#install-compose-on-linux-systems).

### Установка GIT

**Выполнить с root правами.**

Узнать актуальную версию в [исходниках](https://github.com/git/git/releases).

```
export gitVersion=<версия>

cd /tmp \
    && wget https://github.com/git/git/archive/v${gitVersion}.zip -O git.zip \
    && unzip git.zip \
    && cd git-${gitVersion} \
    && make prefix=/usr/local all \
    && make prefix=/usr/local install \
    && cd ~ \
    && rm -rf /tmp/git.zip \
    && rm -rf /tmp/git-${gitVersion}
```

Тест:

`git version`

На основе [инструкции](https://www.digitalocean.com/community/tutorials/how-to-install-git-on-debian-10).

### Добавление SSH ключа для GitHub

```
ssh-keygen -t ed25519 -f ~/.ssh/github -C "<email аккаунта github>"

echo 'Host github.com \
    IdentityFile ~/.ssh/github' \
    >> ~/.ssh/config

cat ~/.ssh/github.pub
```

Скопировать результат вывода `cat` и выполнить добавление ключа в аккаунт github по [инструкции](https://docs.github.com/en/github/authenticating-to-github/adding-a-new-ssh-key-to-your-github-account).

Тест:

`ssh -T git@github.com`

# Установка и настройка приложения

### Клонирование git-репозитория

Создать и перейти в директорию для исходников приложения, например:

`mkdir -p ~/dev/demo && cd ~/dev/demo`

Выполнить:

```
git clone git@github.com:Psaproxy/demo.git \
    && find demo/ -mindepth 1 -maxdepth 1 -exec mv -t ./ -- {} + \
    && rm -rf demo \
```

### Настройка окружения приложения

`cp .env.example .env`

Отредактировать `.env` при необходимости.

### Установка и запуск приложения

`make install`

CLI-тест:

`make cli ARGS=app:test`

WEB-тест:

`http://localhost:13380`

# Установка и настройка приложения

Команды управления в файле `Makefile`.

Ядро проекта в директории `core`.
Инфраструктурный слой в директории `app/Infrastructure`.

Выделение ядра в отдельный слой помогает абстрагироваться от приложения.

Репозитории разделены на:
- Репозиторий - интерфейс коллекции сущностей хранящихся в хранилище.
- Провайдер данных - интерфейс чтения данных из хранилища без "поднятия" доменного слоя, для ускорения.
- Шлюз БД - интерфейс обновления данных в хранилище без "поднятия" доменного слоя, для ускорения.

### Баннер

Контроллер `app/Http/Controllers/BannerController`.
Бизнес-логика `core/Counter`.

CLI команды баннера:
- Сброс кеша баннера `make cli ARGS=banner:reset-cache`
- Сохранение кеша баннера в БД `make cli ARGS=banner:flush-cache`

Принцип работы: Счетчик и дата обновления храняться в кеше (redis). Запись кэшированных данных с помощью CLI-команды по расписанию. Реализован прогрева кеша.

### Каталог книг

Контроллер `app/Http/Controllers/BooksCatalog`.
Бизнес-логика `core/BooksCatalog`.

