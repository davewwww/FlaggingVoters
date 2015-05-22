<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Tests\Fixtures\FooContext;
use Dwo\FlaggingVoters\Voters\DateRangeContextPropertyVoter;
use Dwo\FlaggingVoters\Tests\Fixtures\User;

class DateRangeContextPropertyVoterTest extends \PHPUnit_Framework_TestCase
{
    public function testExtends()
    {
        self::isInstanceOf('Dwo\FlaggingVoters\Voters\DateRangeVoter', new DateRangeContextPropertyVoter(''));
    }

    /**
     * @dataProvider provider
     */
    public function testProvider($result, array $config, $pathContext, Context $context)
    {
        $voter = new DateRangeContextPropertyVoter($pathContext);
        $voteResult = $voter->vote($config, $context);

        self::assertEquals($result, $voteResult, $pathContext.' == '.json_encode($config));
    }

    public function provider()
    {
        $fooContext = new FooContext();
        $fooContext->setUser(new User('foobert', new \DateTime('-12 hours')));

        return array(
            array(true, array('from' => '-13 hours'), 'user.date', $fooContext),
            array(false, array('from' => '-11 hours'), 'user.date', $fooContext),

            array(true, array('to' => '-11 hours'), 'user.date', $fooContext),
            array(false, array('to' => '-13 hours'), 'user.date', $fooContext),

            array(true, array('from' => '-13 hours', 'to' => '-11 hours'), 'user.date', $fooContext),

            array(false, array('from' => '-13 hours'), 'user.foo', $fooContext),
            array(false, array('from' => '-13 hours'), 'date', $fooContext),
            array(false, array(), 'user.date', $fooContext),
        );
    }
}