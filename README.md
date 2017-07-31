![image](http://img.shields.io/badge/Enjoy-Coding!-brightgreen.svg?style=flat)
<!-- [![Built with gulpjs](http://img.shields.io/badge/built%20with-gulp.js-ec6cac.svg?style=flat)](http://gulpjs.com/)
[![npm version](http://img.shields.io/npm/v/npm.svg?style=flat)](https://www.npmjs.org/)
[![node version](https://img.shields.io/node/v/gh-badges.svg?style=flat)](https://www.npmjs.org/) -->

# セーフティマップ 作成用プログラム

## これはなに？
  自転車やオートバイなどの交通事故、ヒヤリハットなどを登録し  
  地図上に表示することができるプログラムです。  


## インストール要件
   - PHP 5.5 以上
   - MySQL 5.1 以上
   - コンソールで PHP CLI が実行できる環境
      * データベースの構築などで、FuelPHP の oil コマンドが実行できる必要があります。


## 使用している主要ソフトウェア
  - [FuelPHP](https://fuelphp.com/)
  - [jQuery](https://jquery.com/)
  - [leaflet.js](http://leafletjs.com/)


## インストール手順

  1.
    本プログラムをサーバ上に展開してください。  
    htdocs が DocumentRoot になることを前提にしているため、  
    環境によってはディレクトリ名を変更、または Apache/Nginx 等の設定を  
    行ってください。  

  2.
    環境変数の設定を Apache または Nginx で行ってください。  
    本番環境では production, テストや開発環境では development が推奨です。  
    [http://fuelphp.jp/docs/1.8/general/environments.html](http://fuelphp.jp/docs/1.8/general/environments.html)  

    - Apache 
        SetEnv FUEL_ENV production
        
    - Nginx
        fastcgi_param FUEL_ENV production

  3.
    fuel/app/config 以下に適切なデータベースの接続設定を行ってください。  
    [http://fuelphp.jp/docs/1.8/classes/database/introduction.html](http://fuelphp.jp/docs/1.8/classes/database/introduction.html)  


  4.
    コンソールなどで、本プログラム最上位の階層で下記のコマンドを実行してください。  
    （oil というファイルが置いてある階層）  
    [http://fuelphp.jp/docs/1.8/general/migrations.html](http://fuelphp.jp/docs/1.8/general/migrations.html)  
    
    ```
    php oil r install
    php oil r migrate
    ```

  5.
    GoogleMap Api を取得の上、下記のGoogleMapAPiのkeyを修正してください。  
    
    - fuel/app/views/admin/point/_form.php
    - fuel/app/views/map/streetview.php   
    - fuel/app/views/map/detail.php       
    - fuel/app/views/map/index.php        
    - fuel/app/views/report/confirm.php   
    - fuel/app/views/report/latlong.php   


## このプログラムをベースにしているウェブサイト

[みんなでつくろう自転車安全マップ](https://bicyclesafetymap.jp/)



### gulp usage

First run.

    $ npm install

Run gulp.

    $ npm run start

Run gulp live-reload-task.

    $ npm run live

package.jsonに依存したモジュールのアップデートがあるかチェック

    $ npm run check

package.jsonに依存したモジュールのアップデート

    $ npm run update
