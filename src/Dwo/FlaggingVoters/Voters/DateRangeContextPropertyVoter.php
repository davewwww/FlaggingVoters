<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\SimpleAccessor\SimpleAccessor;

/**
 * @author David Wolter <david@lovoo.com>
 */
class DateRangeContextPropertyVoter extends DateRangeVoter
{
    /**
     * @var string|null
     */
    protected $contextPropertyPath;

    /**
     * @param string|null $contextPropertyPath
     */
    public function __construct($contextPropertyPath = null)
    {
        $this->contextPropertyPath = $contextPropertyPath;
    }

    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        if (null !== $this->contextPropertyPath) {
            $this->setDateNow(SimpleAccessor::getValueFromPath($context, $this->contextPropertyPath));
        }

        return parent::vote($config, $context);
    }
}
