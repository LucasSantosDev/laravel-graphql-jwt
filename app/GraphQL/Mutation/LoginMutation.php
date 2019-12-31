<?php

declare(strict_types=1);

namespace App\GraphQL\Mutation;

use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Mutation;

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'logIn',
        // 'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return Type::string();
    }

    public function args(): array
    {
        return [
            'email' => [
              'name' => 'email',
              'type' => Type::nonNull(Type::string()),
              'rules' => ['required', 'email'],
            ],
            'password' => [
              'name' => 'password',
              'type' => Type::nonNull(Type::string()),
              'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password']
        ];

        $token = auth()->attempt($credentials);

        if (!$token) {
            throw new \Exception('Unauthorized!');
        }

        return $token;
    }
}
