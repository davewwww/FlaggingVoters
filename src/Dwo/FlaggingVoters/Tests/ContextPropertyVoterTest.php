<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\FlaggingVoters\Tests\Fixtures\FooContext;
use Dwo\FlaggingVoters\Tests\Fixtures\User;
use Dwo\FlaggingVoters\Voters\ContextPropertyVoter;

/**
 * @author David Wolter <david@lovoo.com>
 */
class ContextPropertyVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function testProvider($result, $config, $paths, $context)
    {
        $voter = new ContextPropertyVoter($paths);

        self::assertEquals($result, $voter->vote($config, $context));
    }

    public function provider()
    {
        $context = new FooContext();
        $context->setUser(new User('foobert'));

        return array(
            array(true, ['foobert'], 'user.name', $context),
            array(true, ['lorbert', 'foobert'], 'user.name', $context),
            array(true, ['!lorbert'], ['user.name'], $context),

            array(true, ['foobert'], ['foo.path', 'user.name'], $context),
            array(false, ['foobert'], ['foo.path'], $context),
        );
    }
}