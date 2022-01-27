<?php

namespace Mronald\ControlCnpjApi\Models;

class User extends Model
{
    public function __construct()
    {
        parent::__construct('users', [
            'name',
            'email',
        ]);
    }
}
