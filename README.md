# laravel-admin video js

- add code to composer.json

```php

"repositories": [{
    "type": "git",
    "url": "https://github.com/pengxul/laravel-admin-videojs.git"
  }]

```

- require extends

```php
composer require laravel-admin-ext/video

```

- public assests

```php

php artisan vendor:publish --provider=Pengxul\\Video\\VideoServiceProvider

```

- use

```php

$grid->url()->cvideo();

```
