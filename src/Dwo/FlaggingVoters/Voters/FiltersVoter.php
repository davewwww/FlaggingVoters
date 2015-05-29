<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Factory\FeatureFactory;
use Dwo\Flagging\Model\FilterBag;
use Dwo\Flagging\Voter\FilterGroupsVoter;
use Dwo\Flagging\Voter\VoterInterface;

/**
 * @author David Wolter <david@lovoo.com>
 */
class FiltersVoter implements VoterInterface
{
    /**
     * @var FilterGroupsVoter
     */
    protected $voter;

    /**
     * @param FilterGroupsVoter $filterGroupsVoter
     */
    public function __construct(FilterGroupsVoter $filterGroupsVoter)
    {
        $this->voter = $filterGroupsVoter;
    }

    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        /** @var FilterBag $filter */
        $filter = FeatureFactory::buildFilterBag($config);

        return $filter->hasFilter() ? $this->voter->vote($filter->getFilterGroups(), $context) : true;

    }
}
