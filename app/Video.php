<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    public function permissionStatusFor($user)
    {
        if (! $user) return 'must-sign-in';

        if (! $user->isActive()) return 'must-reactivate';

        return 'should-play';
    }
}
