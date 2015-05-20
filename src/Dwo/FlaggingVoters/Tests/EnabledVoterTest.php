<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Voters\EnabledVoter;

class EnabledTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function test($result, $config)
    {
        $voter = new EnabledVoter();

        self::assertEquals($result, $voter->vote($config, new Context()), $config);
    }

    public function provider()
    {
        return array(
            array(true, true),
            array(true, 'true'),
            array(true, 1),
            array(true, '1'),

            array(false, false),
            array(false, 'false'),
            array(false, 0),
            array(false, '0'),

            array(false, null),
            array(false, 'null'),
            array(false, 'foo'),
        );
    }
}