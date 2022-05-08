<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use DuRoom\Database\Migration;

return Migration::addColumns('users', [
    'flags_read_time' => ['dateTime', 'nullable' => true]
]);
