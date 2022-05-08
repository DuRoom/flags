<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->table('flags', function (Blueprint $table) {
            $table->index('created_at');
        });
    },

    'down' => function (Builder $schema) {
        $schema->table('flags', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });
    }
];
