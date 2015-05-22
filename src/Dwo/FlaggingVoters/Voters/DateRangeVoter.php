<?php

namespace Dwo\FlaggingVoters\Voters;

use DateTime;
use Dwo\Comparator\Comparator;
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
    protected $dateNow;

    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        $from = isset($config['from']) ? $config['from'] : null;
        $to = isset($config['to']) ? $config['to'] : null;

        $d = function($d) {
            if($d instanceof \DateTime) {
                return $d->format('Y-m-d H:i');
            }
            return $d;
        };
        echo $d($from) .' | '. $d($this->getDateNow()).' | '. $d($to) . PHP_EOL;

        return Comparator::compare('date_range', $from, $to, $this->getDateNow());
    }

    /**
     * @return DateTime
     */
    protected function getDateNow()
    {
        return $this->dateNow ?: new DateTime();
    }

    /**
     * @param DateTime|null $dateNow
     */
    public function setDateNow(DateTime $dateNow = null)
    {
        $this->dateNow = $dateNow;
    }
}
