<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Voters\ContextParameterVoter;
use Dwo\FlaggingVoters\Voters\DateRangeVoter;

class DateRangeVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function test($result, array $config, $dateString = 'now')
    {
        $voter = new DateRangeVoter(new \DateTime($dateString ?: 'now'));
        $voteResult = $voter->vote($config, new Context());

        self::assertEquals($result, $voteResult, $dateString.' == '.json_encode($config));
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
        );
    }
}