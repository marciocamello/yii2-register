Wozedu - yii2-register
=============

Project for learning based in Yii 2

Install Application
===================

Installing via Composer <a name="installing-via-composer"></a>
-----------------------

If you do not already have Composer installed, you may do so by following the instructions at
[getcomposer.org](https://getcomposer.org/download/). On Linux and Mac OS X, you'll run the following commands:

    curl -s http://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

On Windows, you'll download and run [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe).

Please refer to the [Composer Documentation](https://getcomposer.org/doc/) if you encounter any
problems or want to learn more about Composer usage.

If you had Composer already installed before, make sure you use an up to date version. You can update Composer
by running `composer self-update`.

With Composer installed, you can install Yii by running the following commands under a Web-accessible folder:

```
composer global require "fxp/composer-asset-plugin:1.0.0-beta4"
composer create-project --prefer-dist --stability=dev marciocamello/yii2-register your-application
```

The first command installs the [composer asset plugin](https://github.com/francoispluchino/composer-asset-plugin/)
which allows managing bower and npm package dependencies through Composer. You only need to run this command
once for all. The second command installs Yii in a directory named `basic`. You can choose a different directory name if you want.

Init Environment
===================

```
php init
```

Configure Database Connection
===================

```
Create a new database and adjust the components.db configuration in common/config/main-local.php accordingly.
```

```php
'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=wozedu_yii2_register',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
```

Migrate User Table
===================

```
php yii migrate
```

Production Backend URL
=====================

```
http://localhost/backend/web
```

Files Source Created and Modified for this project
=================================================

```
backend\config\main-local.php
backend\controllers\UsersController.php
backend\models\Users.php
backend\models\UsersRegisterSearch.php
backend\views\users\_form.php
backend\views\users\_form_password.php
backend\views\users\_search.php
backend\views\users\create.php
backend\views\users\index.php
backend\views\users\update.php
backend\views\users\update_password.php
backend\views\users\view.php
backend\web\.htaccess
composer.json
README.md
```
