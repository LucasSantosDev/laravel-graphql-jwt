# Init (GraphQL + Laravel + JWT)

![Banner](https://blog.pusher.com/wp-content/uploads/2018/04/building-apis-laravel-graphql-header.png)

O arquivo database/database.sqlite deve estar criado caso opte por usar o SQLite.

Execute o migrate
```
php artisan migrate
```

Publicando JWT
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

Gerando código secreto da API
```
php artisan jwt:secret
```
