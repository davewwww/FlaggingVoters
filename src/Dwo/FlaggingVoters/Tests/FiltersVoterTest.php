<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Voters\FiltersVoter;

class FiltersVoterTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $context = new Context();

        $filterGroupVoter = $this->getMockBuilder('Dwo\Flagging\Voter\FilterGroupsVoter')
            ->disableOriginalConstructor()
            ->getMock();
        $filterGroupVoter->expects(self::once())
            ->method('vote')
            ->with(self::isType('array'), $context)
            ->willReturn(true);

        $voter = new FiltersVoter($filterGroupVoter);

        $config = array(
            array(
                'foo'=>['bar']
            )
        );
        self::assertTrue($voter->vote($config, $context));
    }
}