<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Flagging\Context\Context;
use Dwo\Flagging\FeatureDeciderInterface;
use Dwo\Flagging\Voter\VoterInterface;
use Dwo\Flagging\Walker;

/**
 * @author David Wolter <david@lovoo.com>
 */
class FeatureNameVoter implements VoterInterface
{
    /**
     * @var FeatureDeciderInterface
     */
    protected $featureDecider;

    /**
     * @param FeatureDeciderInterface $featureDecider
     */
    public function __construct(FeatureDeciderInterface $featureDecider)
    {
        $this->featureDecider = $featureDecider;
    }

    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        if (is_scalar($config)) {
            $config = array($config);
        }

        return Walker::walkAnd(
            $config,
            function ($featureName) use ($context) {
                $featureNameOrigin = $context->getName();
                $context->setName($featureName);

                $result = $this->featureDecider->decide($featureName, $context, false);

                $context->setName($featureNameOrigin);

                return $result;
            },
            true
        );
    }
}
