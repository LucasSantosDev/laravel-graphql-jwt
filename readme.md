# Init (GraphQL + Laravel + JWT)

![Banner](https://blog.pusher.com/wp-content/uploads/2018/04/building-apis-laravel-graphql-header.png)

O arquivo database/database.sqlite deve estar criado caso opte por usar o SQLite.

Execute o migrate
```
php artisan migrate
```

Execute o Seed para popular a tabela de usuários
```
php artisan db:seed
```

Publicando JWT
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

Gerando código secreto da API
```
php artisan jwt:secret
```

Cadastrando usuário
```
mutation {
  signUp(
    name: "Lucas",
    email: "lucas_ss.arts@live.com", 
    password: "c2994207"
  )
}
```

Logando com usuário
```
mutation {
  logIn(
    email: "lucas_ss.arts@live.com",
    password: "c2994207"
  )
}
```

Consultando listagem de usuário
```
{
  user(paginate: 15, page: 1, name: "a") {
    data {
      id,
      name,
      email,
      posts {
        id,
        title,
        active
      }
    }
    total,
    per_page,
    current_page,
    from,
    to,
    last_page,
    has_more_pages
  },
}
```

Consultando listagem de posts
```
{
  post(paginate: 15, page: 1, active: "n") {
    data {
      id,
      title      
    }
    total,
    per_page,
    current_page,
    from,
    to,
    last_page,
    has_more_pages
  },
}
```
