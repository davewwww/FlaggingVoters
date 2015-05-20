<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;

/**
 * @author David Wolter <david@lovoo.com>
 */
class RandomVoter implements VoterInterface
{
    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        $config = (int) (is_array($config) ? current($config) : $config);

        return mt_rand(0, 100) <= $config;
    }
}
