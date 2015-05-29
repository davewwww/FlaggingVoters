<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Comparator\Comparator;
use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;
use Dwo\Flagging\Walker;
use Dwo\SimpleAccessor\SimpleAccessor;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class ContextPropertyVoter implements VoterInterface
{
    /**
     * @var array
     */
    protected $propertyPaths;

    /**
     * @var null|string
     */
    protected $operator;
    
    /**
     * @var null|string
     */
    protected $walkType;

    /**
     * @param string|array $propertyPaths
     * @param string|null  $operator
     * @param string|null  $walkType
     */
    public function __construct($propertyPaths, $operator = null, $walkType = null)
    {
        $this->propertyPaths = (array) $propertyPaths;
        $this->operator = $operator ?: 'default';
        $this->walkType = $walkType ?: Walker::WALK_OR;
    }

    /**
     * {@inheritDoc}
     */
    public function vote($config, Context $context)
    {
        if(null === $propertyValue = $this->getPropertyValue($context)) {
            return false;
        }

        return Walker::walk(
            $config,
            function ($entry) use ($propertyValue) {
                return Comparator::compare($this->operator, $entry, $propertyValue);
            },
            $this->walkType,
            true
        );
    }

    /**
     * @param Context $context
     *
     * @return mixed|null
     */
    protected function getPropertyValue(Context $context) {

        $propertyValue = null;

        foreach ($this->propertyPaths as $path) {
            if (null !== $propertyValue = SimpleAccessor::getValueFromPath($context, $path)) {
                break;
            }
        }

        return $propertyValue;
    }

}
