<?php

namespace common\tests\unit\entities\User;

use Codeception\Test\Unit;
use shop\entities\User;

class SignupTest extends Unit
{
    public function testSuccess()
    {
        $user = User::requestSignup(
            $userName = 'userName',
            $emailUser = 'email@site.com',
            $passwordUser = '111111'
        );

        $this->assertEquals($userName, $user->username);
        $this->assertEquals($emailUser, $user->email);
        $this->assertNotEmpty($user->password_hash);
        $this->assertNotEquals($passwordUser, $user->password_hash);
        $this->assertNotEmpty($user->created_at);
        $this->assertNotEmpty($user->auth_key);
        $this->assertTrue($user->isActive());
    }
}