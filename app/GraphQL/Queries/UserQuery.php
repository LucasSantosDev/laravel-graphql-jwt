<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use App\GraphQL\Types\UserType;
use App\User;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'user',
        // 'description' => ''
    ];

    public function type(): Type
    {
        return GraphQL::paginate('user');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'Nome de um(ns) registro(s) (%LIKE%)'
            ],
            'paginate' => [
                'type' => Type::int(),
                'defaultValue' => 25,
                'description' => 'Quantidade de registros'
            ],
            'page' => [
                'type' => Type::int(),
                'defaultValue' => 1,
                'description' => 'Pagina específica'
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        // Filtro pelo nome
        $name = isset($args['name']) ? '%'.$args['name'].'%' : false;

        // Para controlar a paginação
        $paginate = $args['paginate'];
        $page     = $args['page'];

        $with = $getSelectFields();

        if ($name) {
            return User::with($with->getRelations())->where('name', 'LIKE', $name)->orderBy('id', 'asc')->paginate($paginate, ['*']);
        }

        return User::with($with->getRelations())->orderBy('id', 'asc')->paginate($paginate, ['*'], 'page', $page);
    }
}
