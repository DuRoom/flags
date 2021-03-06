<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Flags\Event;

use DuRoom\Post\Post;
use DuRoom\User\User;

/**
 * @deprecated 0.1.0-beta.16, remove 0.1.0-beta.17
 * Listen for DuRoom\Flags\Event\Deleting instead
 */
class FlagsWillBeDeleted
{
    /**
     * @var Post
     */
    public $post;

    /**
     * @var User
     */
    public $actor;

    /**
     * @var array
     */
    public $data;

    /**
     * @param Post $post
     * @param User $actor
     * @param array $data
     */
    public function __construct(Post $post, User $actor, array $data = [])
    {
        $this->post = $post;
        $this->actor = $actor;
        $this->data = $data;
    }
}
