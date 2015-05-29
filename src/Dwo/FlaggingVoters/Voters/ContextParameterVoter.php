<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;
use Dwo\Flagging\Walker;

/**
 * @deprecated use ContextPropertyVoter
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class ContextParameterVoter implements VoterInterface
{
    /**
     * @var string
     */
    protected $parameterKey;

    /**
     * @param string $parameterKey
     */
    public function __construct($name, $parameterKey)
    {
        $this->name = $name;
        $this->parameterKey = $parameterKey;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed   $config
     * @param Context $context
     *
     * @return Boolean
     */
    public function vote($config, Context $context)
    {
        return Walker::walkOr(
            $config,
            function ($entry) use ($context) {
                return $entry === $context->getParam($this->parameterKey);
            },
            true
        );
    }
}
