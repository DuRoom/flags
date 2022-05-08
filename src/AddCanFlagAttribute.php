<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Flags;

use DuRoom\Api\Serializer\PostSerializer;
use DuRoom\Post\Post;
use DuRoom\Settings\SettingsRepositoryInterface;
use DuRoom\User\User;

class AddCanFlagAttribute
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(PostSerializer $serializer, Post $post)
    {
        return $serializer->getActor()->can('flag', $post) && $this->checkFlagOwnPostSetting($serializer->getActor(), $post);
    }

    protected function checkFlagOwnPostSetting(User $actor, Post $post): bool
    {
        if ($actor->id === $post->user_id) {
            // If $actor is the post author, check to see if the setting is enabled
            return (bool) $this->settings->get('duroom-flags.can_flag_own');
        }
        // $actor is not the post author
        return true;
    }
}
