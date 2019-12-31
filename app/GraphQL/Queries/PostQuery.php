<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use App\GraphQL\Types\PostType;
use App\Post;

class PostQuery extends Query
{
    protected $attributes = [
        'name' => 'post',
        // 'description' => 'A query'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('post');
    }

    public function args(): array
    {
        return [
            'title' => [
                'type' => Type::string(),
                'description' => 'Título de um(ns) registro(s) (%LIKE%)'
            ],
            'active' => [
                'type' => Type::string(),
                'description' => 'Status de um(ns) registro(s) (active=y|inactive=n)'
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
        $title = isset($args['title']) ? '%'.$args['title'].'%' : null;
        $active = isset($args['active']) ? $args['active'] : null;

        // Para controlar a paginação
        $paginate = $args['paginate'];
        $page     = $args['page'];

        if ($title || $active) {
            return Post::when($title, function ($q, $title) {
                return $q->where('title', 'LIKE', $title);
            })->when($active, function ($q, $active) {
                $active = $active === 'y' ? true : false;

                return $q->where('active', $active);
            })->orderBy('id', 'asc')->paginate($paginate, ['*']);
        }

        return Post::orderBy('id', 'asc')->paginate($paginate, ['*'], 'page', $page);
    }
}
