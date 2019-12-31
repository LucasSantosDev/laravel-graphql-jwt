<?php

declare(strict_types=1);

namespace App\GraphQL\Mutation;

use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Mutation;
use App\User;

class SignUpMutation extends Mutation
{
    protected $attributes = [
        'name' => 'sign',
        // 'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return Type::string();
    }

    public function args(): array
    {
        return [
            'name' => [
              'name' => 'name',
              'type' => Type::nonNull(Type::string()),
              'rules' => ['required'],
            ],
            'email' => [
              'name' => 'email',
              'type' => Type::nonNull(Type::string()),
              'rules' => ['required', 'email', 'unique:users'],
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
        $user = User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => bcrypt($args['password']),
        ]);

        // Gera o token para o usuário e retorna o token
        return auth()->login($user);
    }
}
