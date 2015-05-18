<?php

namespace Dwo\FlaggingVoters\Voters;

use DateTime;
use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;

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
     * @param DateTime $date
     */
    public function __construct(\DateTime $date = null)
    {
        $this->now = $date ?: new DateTime();
    }

    /**
     * :TODO: use Comparison
     * :TODO: check if already date obj
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        if (isset($config['from'], $config['to'])) {
            return new DateTime($config['from']) <= $this->now && new DateTime($config['to']) >= $this->now;
        }

        if (isset($config['from'])) {
            return new DateTime($config['from']) <= $this->now;
        }

        if (isset($config['to'])) {
            return new DateTime($config['to']) >= $this->now;
        }

        return false;
    }
}
