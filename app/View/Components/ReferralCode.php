<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ReferralCode extends Component
{
    public $admin;

    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    public function render()
    {
        return view('components.referral-code');
    }
}
