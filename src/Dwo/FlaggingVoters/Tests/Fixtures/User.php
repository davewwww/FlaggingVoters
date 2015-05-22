<?php

namespace Dwo\FlaggingVoters\Tests\Fixtures;

/**
 * @author David Wolter <david@lovoo.com>
 */
class User
{
    protected $name;
    protected $date;

    public function __construct($name = null, $date=null)
    {
        $this->name = $name;
        $this->date = $date;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDate()
    {
        return $this->date;
    }
}