# Weekly Duty Roster with Web


## Requirements

Docker(>=17.05)

## Usage

1. .envファイルをコピーする
```
コピー先で設定は自由に変えて頂いて構いません。
$ cp .env-sample .env
```

2. dockerを起動する
```
起動
$ docker-compose up -d
（初回はビルドが入るため、時間がかかります）

終了
$ docker-compose down
```

3. Laravelをインストールする

bashでdocker環境に入る
```
$ docker exec -it php bash
```

Laravelをインストールする
```
if php >= 7.3.0
$ laravel new laravel

else
$ composer create-project laravel/laravel laravel
```

[data](./data)配下にLaravelがインストールされていることを確認する

4. localhostに接続する

laravelの初期画面が表示されることを確認する

5. [.env](./.env)の内容をLaravel内に反映させる

## Settings

### ・Portを変更する
1. [docker-compose.yml](./docker-compose.yml)を開く
2. 変更したいコンテナのportsを書き換える
3. （docker動作中なら）コンテナを再起動する

### ・PHP My Adminのインポートサイズを変更する
1. [upload.ini](./docker/phpmyadmin/upload.ini)を開く
2. 設定値を変更する
```
例

upload_max_filesize=128M
```

### GDの設定値を変更する
PHP 7.4以降はGDのパラメータが異なるようなので注意。

1. PHPの[Dockerfile](./docker/php/Dockerfile)を開く

2. ` docker-php-ext-configure `を修正する
```
# Exsample: (PHP 7.4)

# 7.4以降は末尾のdirがない
docker-php-ext-configure --with-freetype=/usr/include/
```

### PHP 7.3以降でzlib1g-devのインストールが失敗する

`zlib1g-dev`のインストールを`libzip-dev`のインストールに変更してください

## Available by default

・PHP

・MySQL

・PHP My Admin

・Laravel
