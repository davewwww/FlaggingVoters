<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Voters\StringVoter;

class StringVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function test($result, $config, $string, $strict = true)
    {
        $voter = new StringVoter($string, $strict);

        self::assertEquals($result, $voter->vote($config, new Context()), json_encode($config));
    }

    public function provider()
    {
        return array(
            array(true, 'prod', 'prod'),
            array(false, '!prod', 'prod'),
            array(true, '!prod', 'dev'),
            array(true, ['dev', 'prod'], 'prod'),
            array(false, 'dev', 'prod'),
            array(false, ['dev', 'prod'], 'test'),
            array(true, 'foo', 'foo'),
            array(false, 'foo', 'foobar'),
            array(true, 'foo', 'foobar', false),
            array(true, ['foo', 'bar'], 'foobar', false),
        );
    }
}