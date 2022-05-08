<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Flags\Api\Serializer;

use DuRoom\Api\Serializer\AbstractSerializer;
use DuRoom\Api\Serializer\BasicUserSerializer;
use DuRoom\Api\Serializer\PostSerializer;

class FlagSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'flags';

    /**
     * {@inheritdoc}
     */
    protected function getDefaultAttributes($flag)
    {
        return [
            'type'         => $flag->type,
            'reason'       => $flag->reason,
            'reasonDetail' => $flag->reason_detail,
            'createdAt'    => $this->formatDate($flag->created_at),
        ];
    }

    /**
     * @return \Tobscure\JsonApi\Relationship
     */
    protected function post($flag)
    {
        return $this->hasOne($flag, PostSerializer::class);
    }

    /**
     * @return \Tobscure\JsonApi\Relationship
     */
    protected function user($flag)
    {
        return $this->hasOne($flag, BasicUserSerializer::class);
    }
}
