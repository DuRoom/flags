<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Flags;

use DuRoom\Api\Serializer\CurrentUserSerializer;
use DuRoom\User\User;

class AddNewFlagCountAttribute
{
    public function __invoke(CurrentUserSerializer $serializer, User $user)
    {
        return (int) $this->getNewFlagCount($user);
    }

    /**
     * @param User $actor
     * @return int
     */
    protected function getNewFlagCount(User $actor)
    {
        $query = Flag::whereVisibleTo($actor);

        if ($time = $actor->read_flags_at) {
            $query->where('flags.created_at', '>', $time);
        }

        return $query->distinct()->count('flags.post_id');
    }
}
