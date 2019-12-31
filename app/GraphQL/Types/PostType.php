<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PostType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Post',
        'description' => 'Endpoint de posts'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'O ID do post dentro do banco de dados'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'O title do post dentro do banco de dados'
            ],
            'active' => [
                'type' => Type::boolean(),
                'description' => 'O status do post (active=true|inactive=false) dentro do banco de dados'
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'O id do usuário que criou o post dentro do banco de dados'
            ]
        ];
    }
}
