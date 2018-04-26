<?php

namespace App\Billing;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function inDollars()
    {
        return number_format($this->amount /100, 2);
    }
}
