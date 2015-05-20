<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Voters\RandomVoter;

class RandomVoterTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $voter = new RandomVoter();

        self::assertTrue($voter->vote(100, new Context()));
        self::assertFalse($voter->vote(0, new Context()));
    }

    public function testAsArray()
    {
        $voter = new RandomVoter();

        self::assertTrue($voter->vote([100], new Context()));
        self::assertFalse($voter->vote([0], new Context()));
    }
}