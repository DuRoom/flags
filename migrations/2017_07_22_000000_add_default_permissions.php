<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use DuRoom\Database\Migration;
use DuRoom\Group\Group;

return Migration::addPermissions([
    'discussion.flagPosts' => Group::MEMBER_ID,
    'discussion.viewFlags' => Group::MODERATOR_ID
]);
