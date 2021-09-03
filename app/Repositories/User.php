<?php

namespace App\Repositories;

use Api\Repositories\Contracts\Resource;
use Api\Repositories\Contracts\User as UserContract;
use Illuminate\Support\Facades\Hash;

class User extends Repository implements Resource, UserContract
{
    /**
     * @param string $id
     * @return array|null
     */
    public function getById(string $id): ?array
    {
        return (new \App\Resources\User())->getModel()->query()->where('id', $id)->first()->toArray() ?: null;
    }

    /**
     * @param string $username
     * @param string $password
     * @return string|null
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getIdByCredentials(string $username, string $password): ?string
    {
        $user = (new \App\Resources\User())->getModel()->query()->where('email', 'like', $username)->first();

        return $user && $user->email_confirmed && Hash::check($password, $user->password) ? $user->id : null;
    }
}
