<?php

namespace Dwo\FlaggingVoters\Voters;

use DateTime;
use Dwo\Comparator\Comparator;
use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;
use Dwo\SimpleAccessor\SimpleAccessor;

/**
 * @author David Wolter <david@lovoo.com>
 */
class DateRangeVoter implements VoterInterface
{
    /**
     * @var \DateTime
     */
    protected $now;
    /**
     * @var string|null
     */
    protected $contextPropertyPath;

    /**
     * @param DateTime|null $date
     * @param string|null   $contextPropertyPath
     */
    public function __construct(DateTime $date = null, $contextPropertyPath = null)
    {
        $this->now = $date ?: new DateTime();
        $this->contextPropertyPath = $contextPropertyPath;
    }

    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        $dateFromContext = null;
        if (null !== $this->contextPropertyPath) {
            $dateFromContext = SimpleAccessor::getValueFromPath($context, $this->contextPropertyPath);
        }


        $from = isset($config['from']) ? $config['from'] : null;
        $to = isset($config['to']) ? $config['to'] : null;
        $dateNow = null !== $dateFromContext ? $dateFromContext : $this->now;

        return Comparator::compare('date_range', $from, $to, $dateNow);
    }
}
