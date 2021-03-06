<?php

namespace Dwo\FlaggingVoters\Voters;

use Dwo\Comparator\Comparator;
use Dwo\Flagging\Walker;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
abstract class AbstractPropertyVoter
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
     * @var null|string
     */
    protected $thirdCompareParam;

    /**
     * @param string|array $propertyPaths
     * @param string|null  $operator
     * @param string|null  $walkType
     * @param string|null  $thirdCompareParam
     */
    public function __construct($propertyPaths, $operator = null, $walkType = null, $thirdCompareParam = null)
    {
        $this->propertyPaths = (array) $propertyPaths;
        $this->operator = $operator ?: 'default';
        $this->walkType = $walkType ?: Walker::WALK_OR;
        $this->thirdCompareParam = $thirdCompareParam;
    }

    /**
     * {@inheritDoc}
     */
    public function walk($config, $propertyValue)
    {
        return Walker::walk(
            $config,
            function ($entry) use ($propertyValue) {
                return Comparator::compare($this->operator, $entry, $propertyValue, $this->thirdCompareParam);
            },
            $this->walkType,
            true
        );
    }
}
