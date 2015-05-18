<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Voters\FeatureNameVoter;

class FeatureNameVoterTest extends \PHPUnit_Framework_TestCase
{
    public function testTrue()
    {
        $context = new Context();
        $decider = $this->getMockBuilder('Dwo\Flagging\FeatureDeciderInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $decider->expects(self::once())
            ->method('decide')
            ->with('foo', $context)
            ->willReturn(true);

        $voter = new FeatureNameVoter($decider);

        self::assertTrue($voter->vote('foo', $context));
    }

    public function testFalse()
    {
        $context = new Context();
        $decider = $this->getMockBuilder('Dwo\Flagging\FeatureDeciderInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $decider->expects(self::once())
            ->method('decide')
            ->with('foo', $context)
            ->willReturn(false);

        $voter = new FeatureNameVoter($decider);

        self::assertFalse($voter->vote('foo', $context));
    }
}