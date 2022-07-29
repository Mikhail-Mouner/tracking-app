# Tracking App | Task

### _Developing By Mikhail_

- [mikhaeelmouner@yahoo.com](mailto:mikhaeelmouner@yahoo.com)
- [+20 120 6111 051](tel:+201206111051)

### Installation

```sh
git clone https://github.com/Mikhail-Mouner/tracking-app.git
```

```sh
cd tracking-app
```

```sh
cp .env.example .env
```

```sh
composer install
```

Create Table Name( tracking-app )

```sh
php artisan migrate --seed
```

```sh
php artisan serve
```

use username : test username
password : 123456

Go to Home Page http://127.0.0.1:800/

Go to Api Doc http://127.0.0.1:800/api/readme
Or
Import from postman this collection :
https://github.com/Mikhail-Mouner/tracking-app/blob/master/Tracking-App.postman_collection.json

### For PHPUnit Test

```sh
php artisan test
```

