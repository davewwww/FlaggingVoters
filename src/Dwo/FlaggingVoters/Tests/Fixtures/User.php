<?php

namespace Dwo\FlaggingVoters\Tests\Fixtures;

/**
 * @author Dave Www <davewwwo@gmail.com>
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