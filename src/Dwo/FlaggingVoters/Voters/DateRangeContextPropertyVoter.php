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
//        if (null === $propertyValue = SimpleAccessor::getValueFromPath($context, $this->contextPropertyPath)) {
//            return false;
//        }

        $propertyValue = SimpleAccessor::getValueFromPath($context, $this->contextPropertyPath);

        //dump
        $d = $propertyValue instanceof \DateTime ? $propertyValue->format('Y-m-d H:i') : $propertyValue;
        echo PHP_EOL.json_encode(array($config, $this->contextPropertyPath, $d)).PHP_EOL;

        if (null === $propertyValue) {
            var_dump($context);
            return false;
        }

        $this->setDateNow($propertyValue);

        return parent::vote($config, $context);
    }
}
