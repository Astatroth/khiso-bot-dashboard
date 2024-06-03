<?php

namespace App\Overrides;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class AuthUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    #[\Override]
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return null;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();

        $query->where(function ($q) use ($credentials) {
            if (isset($credentials['email']) && !is_null($credentials['email'])) {
                $q->where('email', $credentials['email']);
            } else {
                if (isset($credentials['phone'])) {
                    $q->where('phone', $credentials['phone']);
                }
            }
        });

        return $query->first();
    }

    /**
     * Validate a user against the given credentials.
     * OVERRIDE
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    #[\Override]
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }
}
