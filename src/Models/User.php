<?php

namespace Laralum\Payments\Models;

use Laravel\Cashier\Billable;
use Laralum\Users\Models\User as ExtendedUser;

class User extends ExtendedUser
{
    use Billable;
}
