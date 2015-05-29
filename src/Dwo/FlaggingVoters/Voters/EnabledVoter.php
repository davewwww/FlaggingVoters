<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class EnabledVoter implements VoterInterface
{
    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        $config = is_array($config) ? current($config) : $config;

        if (!is_bool($config)) {
            if (in_array($config, array(1, '1', 'true'), true)) {
                $config = true;
            } else {
                $config = false;
            }
        }

        return (bool) $config;
    }
}
