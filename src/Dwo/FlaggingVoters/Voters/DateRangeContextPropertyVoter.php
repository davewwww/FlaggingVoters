<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\SimpleAccessor\SimpleAccessor;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class DateRangeContextPropertyVoter extends DateRangeVoter
{
    /**
     * @var string
     */
    protected $contextPropertyPath;

    /**
     * @param string $contextPropertyPath
     */
    public function __construct($contextPropertyPath)
    {
        $this->contextPropertyPath = $contextPropertyPath;
    }

    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        if (null === $propertyValue = SimpleAccessor::getValueFromPath($context, $this->contextPropertyPath)) {
            return false;
        }

        $this->setDateNow($propertyValue);

        return parent::vote($config, $context);
    }
}
