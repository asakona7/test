#問い合わせフォーム
一般的な問い合わせフォームです。
必須事項を書いてもらい、ご意見を送っていただけるアプリです。

![TOP](https://github.com/naoki28aida/trainingtest/assets/138663818/77a1bcb6-aec3-4ab4-a93b-8bdc94fcca1c)

##目的
確認テストのためです。

##URL
問い合わせフォームがホームページになっており、
管理画面が/contacts/searchになっています。

##機能
問い合わせ機能にはバリデーションを利用し、
必須事項がなければ送信できなくなっております。
管理画面では各項目から検索して登録者を探せます。
削除機能も付いています。

##仕様技術
Laravelフレームワーク、Dockerを利用し、
HTML(Blade)、PHP:7.4.9、CSS、mySQLなどを使いました。

##テーブル設計
![テーブル設計](img/contacts_table.png)

##ER図
![ER図](img/test.drawio.png)

##開発
環境Windows11上でlinuxを作りました。