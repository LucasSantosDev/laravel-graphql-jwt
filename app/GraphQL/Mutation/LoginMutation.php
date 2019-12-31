<?php

declare(strict_types=1);

namespace App\GraphQL\Mutation;

use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Mutation;
use JWTAuth;

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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password']
        ];

        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            throw new \Exception('Unauthorized!');
        }

        return $token;
    }
}
