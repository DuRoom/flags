<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Flags;

use DuRoom\Api\Serializer\ForumSerializer;
use DuRoom\Settings\SettingsRepositoryInterface;
use DuRoom\User\User;

class AddFlagsApiAttributes
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

    public function __invoke(ForumSerializer $serializer)
    {
        $attributes = [
            'canViewFlags' => $serializer->getActor()->hasPermissionLike('discussion.viewFlags')
        ];

        if ($attributes['canViewFlags']) {
            $attributes['flagCount'] = (int) $this->getFlagCount($serializer->getActor());
        }

        return $attributes;
    }

    /**
     * @param User $actor
     * @return int
     */
    protected function getFlagCount(User $actor)
    {
        return Flag::whereVisibleTo($actor)->distinct()->count('flags.post_id');
    }
}
