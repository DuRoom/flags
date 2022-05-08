<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Flags\Listener;

use DuRoom\Post\Event\Deleted;

class DeleteFlags
{
    /**
     * @param Deleted $event
     */
    public function handle(Deleted $event)
    {
        $event->post->flags()->delete();
    }
}
