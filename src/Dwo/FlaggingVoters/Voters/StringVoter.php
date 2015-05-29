<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;
use Dwo\Flagging\Walker;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class StringVoter implements VoterInterface
{
    /**
     * @var string
     */
    protected $string;

    /**
     * @var bool
     */
    protected $strict;

    /**
     * @param string $string
     * @param bool   $strict
     */
    public function __construct($string, $strict = true)
    {
        $this->string = $string;
        $this->strict = $strict;
    }

    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        if (is_scalar($config)) {
            $config = array($config);
        }

        return Walker::walkOr(
            $config,
            function ($entry) use ($context) {
                if ($this->strict) {
                    return $this->string === $entry;
                } else {
                    return false !== strpos($this->string, $entry);
                }
            },
            true
        );
    }
}
