<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Comparator\Comparator;
use Dwo\Flagging\Context\Context;
use Dwo\Flagging\Voter\VoterInterface;
use Dwo\Flagging\Walker;
use Dwo\SimpleAccessor\SimpleAccessor;

/**
 * @author David Wolter <david@lovoo.com>
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
    protected $walkType;

    /**
     * @var null|string
     */
    protected $operator;

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
        $propertyValue = null;

        foreach ($this->propertyPaths as $path) {
            if (null !== $propertyValue = SimpleAccessor::getValueFromPath($context, $path)) {
                break;
            }
        }

        if (null === $propertyValue) {
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
    }}
