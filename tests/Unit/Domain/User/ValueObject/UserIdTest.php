<?php

namespace Tests\Unit\Domain\User\ValueObject;

use App\Domain\User\ValueObject\UserId;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    public function testUserIdCreation()
    {
        $id = '12345';
        $userId = new UserId($id);

        $this->assertEquals($id, $userId->getValue());
    }

    public function testUserIdEquality()
    {
        $id1 = new UserId('12345');
        $id2 = new UserId('12345');
        $id3 = new UserId('67890');

        $this->assertTrue($id1->getValue() === $id2->getValue());
        $this->assertFalse($id1->getValue() === $id3->getValue());
    }
}