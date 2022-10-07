# Weekly Duty Roster with Web

## これ何のアプリ？

当番表を簡単に作成できるアプリです

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
起動するとき
（初回）
$ docker-compose up -d --build
（以降）
$ docker-compose up -d

終了するとき
$ docker-compose down
```

3. phpコンテナにアクセスし、ライブラリ一式をダウンロード
```
（コンテナに入る）
$ docker exec -it ${コンテナ名} bash
（ライブラリをダウンロードする）
$ composer install
$ npm i && npm run prod
```

4. Laravelのenvファイルを設定する
```
$ cp .env.example .env
$ vi .env （viでなくても編集できれば良いです）

設定が完了したら
$ php artisan config:clear

$ php artisan tinker
>> DB::select('select 1');
!! ここでエラーが出た場合、envファイルに設定したDB情報が正しいか再度確認してください !!
```

5. DBにテーブルを作成する
```
$ php artisan migrate
```
6. テストユーザーを作成する
```
$ php artisan db:seed
```

`data/database/seeders/CreateUsersSeeder.php` にテストユーザーの情報が記載されています。
（本環境では利用しないでください）

7. localhostにアクセスしてログインできるか確認する

追記予定

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
