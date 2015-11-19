Http
====
simple way to do http request

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist sillydong/yii2-http "*"
```

or add

```
"sillydong/yii2-http": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
\sillydong\http\Client::get($url);

\sillydong\http\Client::post($url, $body, $headers);

\sillydong\http\Client::multipartPost($url, $fields, $name, $fileName, $fileBody, $mimeType, $headers);
```
