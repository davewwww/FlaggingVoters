<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Voters\HeaderPropertyVoter;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class HeaderPropertyVoterTest extends \PHPUnit_Framework_TestCase
{
    public function testStringEquals()
    {
        $_SERVER['x-name'] = 'foo';

        $voter = new HeaderPropertyVoter('x-name');

        self::assertTrue($voter->vote(['foo'], new Context()));
    }

    public function testStringEqualsFalse()
    {
        $_SERVER['x-name'] = 'foo';

        $voter = new HeaderPropertyVoter('x-name');

        self::assertFalse($voter->vote(['bar'], new Context()));
    }

    public function testVersionEqualsOk()
    {
        $_SERVER['x-version'] = '1.2.9';

        $voter = new HeaderPropertyVoter('x-version', 'version');

        self::assertTrue($voter->vote(['1.2.9'], new Context()));
    }

    public function testVersionGreaterOk()
    {
        $_SERVER['x-version'] = '1.3.1';

        $voter = new HeaderPropertyVoter('x-version', 'version');

        self::assertTrue($voter->vote(['1.2.9'], new Context()));
    }

    public function testVersionLowerFalse()
    {
        $_SERVER['x-version'] = '1.3.1';

        $voter = new HeaderPropertyVoter('x-version', 'version');

        self::assertFalse($voter->vote(['1.4.9'], new Context()));
    }

    public function testKeyNotExists()
    {
        $_SERVER['x-word'] = 'foo';

        $voter = new HeaderPropertyVoter('x-name');

        self::assertFalse($voter->vote(['foo'], new Context()));
    }

    public function testMultipleKeys()
    {
        $_SERVER['x-word'] = 'foo';

        $voter = new HeaderPropertyVoter(['x-name', 'x-word']);

        self::assertTrue($voter->vote(['foo'], new Context()));
    }

}