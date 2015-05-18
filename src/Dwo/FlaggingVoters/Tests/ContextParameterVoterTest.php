<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Voters\ContextParameterVoter;

class ContextParameterVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function test($result, $country, $countries)
    {
        $voter = new ContextParameterVoter('countries', 'country');
        $voteResult = $voter->vote($countries, new Context(array('country' => $country)));

        self::assertEquals($result, $voteResult, $country.' == '.json_encode($countries));
    }

    public function provider()
    {
        return array(
            array(true, 'DE', array('DE')),
            array(true, 'US', array('!DE')),
            array(true, 'US', array('DE', 'US')),
            array(true, 'AT', array('DE', 'US', 'AT')),
            array(true, 'AT', array('!DE', '!US')),
            array(false, 'DE', array('!DE')),
            array(false, 'DE', array('US')),
            array(false, 'DE', array('AT', 'US')),
        );
    }
}