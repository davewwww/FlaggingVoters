<?php

namespace Dwo\FlaggingVoters\Tests\Fixtures;

use Dwo\Flagging\Context\Context;
use Usac\Campaign\Model\CampaignAwareTrait;
use Usac\Campaign\Model\CampaignInterface;
use Usac\Project\Model\ProjectAwareTrait;

/**
 * @author David Wolter <david@lovoo.com>
 */
class FooContext extends Context
{
    protected $user;

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}