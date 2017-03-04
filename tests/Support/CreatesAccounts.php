<?php

namespace Tests\Support;

use App\User;
use App\Account;

// Make sure to Autoload in composer json
trait CreatesAccounts {

    public function createAccount($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $account = (new Account)->forceFill([
            'name' => 'Hockey Org',
            'owner_id' => $user->id
        ]);

        $user->accounts()->save($account);

        return $account->fresh();
    }
}
