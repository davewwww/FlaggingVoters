<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Voters\ExpressionVoter;
use Dwo\FlaggingVoters\Voters\RandomVoter;

class ExpressionVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function test($result, $expression, array $params = array())
    {
        $voter = new ExpressionVoter();
        $voteResult = $voter->vote($expression, new Context($params));

        self::assertEquals($result, $voteResult, $expression.' | '.json_encode($params));
    }

    public function provider()
    {
        $class = new \stdClass();
        $class->foo = 'bar';
        $class->bar = array(2=>3);

        return array(
            array(true, 'foo == 2', array('foo' => 2)),
            array(false, 'foo == 3', array('foo' => 2)),
            array(true, 'foo == 2 && bar == "lorem"', array('foo' => 2, 'bar' => 'lorem')),
            array(true, 'foo.foo == "bar" && foo.bar[2] == 3', array('foo' => $class)),

            array(true, 'in_array(2, foo)', array('foo' => [2,3])),
            array(true, '!in_array(4 ,foo)', array('foo' => [2,3])),

            array(true, '!empty(foo)', array('foo' => [2,3])),
            array(true, 'empty(foo)', array('foo' => [])),

            array(true, '2 == count(foo)', array('foo' => [2,3])),
            array(false, '2 == count(foo)', array('foo' => [])),

            array(true, '"foo" == strtolower(foo)', array('foo' => 'FOO')),
            array(false, '"foo" == foo', array('foo' => 'FOO')),

            array(true, 'preg_match("/^\\\w{3}\\\d{2}$/", foo)', array('foo' => 'foo45'))

        );
    }
}