<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class HeaderPropertyVoter extends AbstractPropertyVoter implements VoterInterface
{
    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        if (null === $propertyValue = $this->getPropertyValue()) {
            return false;
        }

        return self::walk($config, $propertyValue);
    }

    /**
     * @return mixed|null
     */
    protected function getPropertyValue()
    {
        $propertyValue = null;

        foreach ($this->propertyPaths as $path) {
            if (isset($_SERVER[$path])) {
                $propertyValue = $_SERVER[$path];
                break;
            }
        }

        return $propertyValue;
    }

}
