<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Flags\Event;

use DuRoom\Flags\Flag;
use DuRoom\User\User;

class Deleting
{
    /**
     * @var Flag
     */
    public $flag;

    /**
     * @var User
     */
    public $actor;

    /**
     * @var array
     */
    public $data;

    /**
     * @param Flag $flag
     * @param User $actor
     * @param array $data
     */
    public function __construct(Flag $flag, User $actor, array $data = [])
    {
        $this->flag = $flag;
        $this->actor = $actor;
        $this->data = $data;
    }
}
