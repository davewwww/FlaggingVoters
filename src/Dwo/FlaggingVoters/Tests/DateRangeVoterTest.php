<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Tests\Fixtures\FooContext;
use Dwo\FlaggingVoters\Voters\ContextParameterVoter;
use Dwo\FlaggingVoters\Voters\DateRangeVoter;
use Dwo\SimpleAccessor\Tests\Fixtures\User;

class DateRangeVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function test($result, array $config, $dateNow = null)
    {
        $voter = new DateRangeVoter();
        if(null !== $dateNow) {
            $voter->setDateNow(new \DateTime($dateNow));
        }

        $voteResult = $voter->vote($config, new Context());

        self::assertEquals($result, $voteResult, $dateNow.' == '.json_encode($config));
    }

    public function provider()
    {
        return array(
            array(true, array('from' => '-1 day')),
            array(true, array('to' => '+1 day')),
            array(true, array('from' => '-1 day', 'to' => '+1 day')),

            array(false, array('from' => '+1 day')),
            array(false, array('to' => '-1 day')),
            array(false, array('from' => '+1 day', 'to' => '+2 day')),

            array(true, array('from' => '-12 day', 'to' => '-10 day'), '-11 day'),
            array(false, array('from' => '-12 day', 'to' => '-10 day'), '-13 day'),

            array(false, array()),
        );
    }
}