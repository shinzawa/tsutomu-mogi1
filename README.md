# フリマ

## 環境構築
### Dockerビルド
1. git clone リンク
1. docker-compose up -d --build
### Laravel 環境構築
1. docker-compose exec php bash
1. composer install
1. .env.exampleファイルから.envを作成し、環境変数を変更
```diff_php:.envファイル
// 前略

DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
+ DB_HOST=mysql
DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=root
- DB_PASSWORD=
+ DB_DATABASE=laravel_db
+ DB_USERNAME=laravel_user
+ DB_PASSWORD=laravel_pass
// 中略
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
- MAIL_USERNAME=null
- MAIL_PASSWORD=null
+ MAIL_USERNAME=sample
+ MAIL_PASSWORD=sample
MAIL_ENCRYPTION=null
- MAIL_FROM_ADDRESS=null
+ MAIL_FROM_ADDRESS=sample@laravel.jp
MAIL_FROM_NAME="${APP_NAME}"

// 後略
```
1. php artisan key:generate
1. php artisan migrate
1. php artisan db:seed
1. chmod -R 777 storage bootstrap/cache
1. php artisan storage:link

ここまで通常の環境設定です。ここからは追加でFeatureTest とDustTest の環境構築の記述になります。

まず、FeatureTest は以下を追加します。
1. テスト用データーベースの準備
```
MySQL コンテナに入る
$ docker-compose exec mysql bash
$ mysql -u root -p
> CREATE DATABASE demo_test;
> SHOW DATABASES;
```

1. database.php の編集(FeatureTest で用いるデーターベースの設定)
```diff_php:database.php
'mysql' => [
// 中略
],

+ 'mysql_test' => [
+             'driver' => 'mysql',
+             'url' => env('DATABASE_URL'),
+             'host' => env('DB_HOST', '127.0.0.1'),
+             'port' => env('DB_PORT', '3306'),
+             'database' => 'demo_test',
+             'username' => 'root',
+             'password' => 'root',
+             'unix_socket' => env('DB_SOCKET', ''),
+             'charset' => 'utf8mb4',
+             'collation' => 'utf8mb4_unicode_ci',
+             'prefix' => '',
+             'prefix_indexes' => true,
+             'strict' => true,
+             'engine' => null,
+             'options' => extension_loaded('pdo_mysql') ? array_filter([
+                 PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
+             ]) : [],
+ ],
```
.env をコピーして.env.testing を作成する
```
cp src/.env src/.env.testing
```
.env.testing ファイルの始めのAPP_ENV と APP_KEY を編集する
```diff_php:.env.testing
APP_NAME=Laravel
- APP_ENV=local
- APP_KEY=base64:vPtYQu63T1fmcyeBgEPd0fJ+jvmnzjYMaUf7d5iuB+c=
+ APP_ENV=testing
+ APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
```
.env.testing に データベースの接続情報を追加する。
```diff_php:.env.testing
  DB_CONNECTION=mysql_test
  DB_HOST=mysql
  DB_PORT=3306
- DB_DATABASE=laravel_db
- DB_USERNAME=laravel_user
- DB_PASSWORD=laravel_pass
+ DB_DATABASE=demo_test
+ DB_USERNAME=root
+ DB_PASSWORD=root
```
APP_KEY に新たなテスト用アプリケーションキーを追加する
```PHPコンテナ上
$ php artisan key:generate --env=testing
$ php artisan config:clear
```

1. php artisan migrate --env=testing
1. php artisan db:seed --env=testing
1. chmod -R 777 storage bootstrap/cache
1. php artisan storage:link
ここまでが、FeatureTest の手順でした。

ここからは、DustTest の環境設定です。
1. .env から.env.dusk.local をcopy して編集する
```
cp src/.env src/.env.dusk.local
```
.env.dusk.local ファイルの始めのAPP_ENV と APP_KEY APP_URL  を編集する。
```diff_php:.env.dusk.local
APP_NAME=Laravel
- APP_ENV=local
- APP_KEY=base64:vPtYQu63T1fmcyeBgEPd0fJ+jvmnzjYMaUf7d5iuB+c=
+ APP_ENV=testing
+ APP_KEY=
APP_DEBUG=true
- APP_URL=http://localhost
+ APP_URL=http://nginx
```
.env.dusk.local に データベースの接続情報を追加する。
```diff_php:.env.testing
  DB_CONNECTION=mysql_test
  DB_HOST=mysql
  DB_PORT=3306
- DB_DATABASE=laravel_db
- DB_USERNAME=laravel_user
- DB_PASSWORD=laravel_pass
+ DB_DATABASE=demo_test
+ DB_USERNAME=root
+ DB_PASSWORD=root
```
APP_KEY に新たなテスト用アプリケーションキーを追加する
```PHPコンテナ上

1. php artisan key:generate --env=dusk.local
1. php artisan migrate --env=dusk.local
1. php artisan db:seed --env=dusk.local
1. chmod -R 777 storage bootstrap/cache
1. php artisan storage:link
1. php artisan dusk:install
1. src/tests/DuskTestCase.php を編集
1.1. prepare() 関数の中身をcomment out
    public static function prepare()
    {
        // if (! static::runningInSail()) {
        //     static::startChromeDriver();
        // }
    }
1.1. option を追加
            return $items->merge([
                '--disable-gpu',
                '--headless',
                '--no-sandbox',
                '--disable-dev-shm-usage',
	]);


## 使用技術（実行環境）
PHP 8.1.33 
Laravel Framework 8.83.8
Ubuntu 24.04.2 LTS (on WSL)
nginx:1.21.1
## ER図
![ER図](ER.drawio.png)
## URL
- ユーザー登録: http//localhost/register
- 開発環境: http://localhost
