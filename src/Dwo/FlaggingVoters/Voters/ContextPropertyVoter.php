<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;
use Dwo\SimpleAccessor\SimpleAccessor;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class ContextPropertyVoter extends AbstractPropertyVoter implements VoterInterface
{
    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        if (null === $propertyValue = $this->getPropertyValue($context)) {
            return false;
        }

        return self::walk($config, $propertyValue);
    }

    /**
     * @param Context $context
     *
     * @return mixed|null
     */
    protected function getPropertyValue(Context $context)
    {
        $propertyValue = null;

        foreach ($this->propertyPaths as $path) {
            if (null !== $propertyValue = SimpleAccessor::getValueFromPath($context, $path)) {
                break;
            }
        }

        return $propertyValue;
    }

}
