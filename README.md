The UEFA Euro 2020 prediction contest web app
## Install

- download the code
- create database from /database/euro2020.sql 
- edit .env
- composer install
- php artisan key:generate
- take care of file permissions

## Description

Demo: [ALRO](http://euro2020.alronet.ch/)  Please do not register in this site.

UI based on [lsv/fifa-worldcup-2018-jsfrontend](https://github.com/lsv/fifa-worldcup-2018-jsfrontend)

![UI](https://github.com/zhengfen/euro2020/blob/main/public/images/foot_ui.png)

- Rules for calculating points is defined in Model User points()
- Deadline for prediction update is defined in PredictonController and store/modules/games getters.disabled; One day before the first game.


## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
