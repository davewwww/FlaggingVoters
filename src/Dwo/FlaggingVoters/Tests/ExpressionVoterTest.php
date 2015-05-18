<?php

namespace Dwo\FlaggingVoters\Tests;

use Dwo\Flagging\Context\Context;
use Dwo\FlaggingVoters\Voters\ExpressionVoter;
use Dwo\FlaggingVoters\Voters\RandomVoter;

class ExpressionVoterTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $expressionLanguage = $this->getMockBuilder('Symfony\Component\ExpressionLanguage\ExpressionLanguage')
            ->disableOriginalConstructor()
            ->getMock();
        $expressionLanguage->expects(self::once())
            ->method('evaluate')
            ->with('foo',array('foo'=>'bar'))
            ->willReturn(true);

        $voter = new ExpressionVoter($expressionLanguage);
        $voteResult = $voter->vote(array('foo'), new Context(array('foo'=>'bar')));

        self::assertTrue($voteResult);
    }

    /**
     * @dataProvider provider
     */
    public function testProvider($result, $expression, array $params = array())
    {
        $voter = new ExpressionVoter();
        $voteResult = $voter->vote(array($expression), new Context($params));

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