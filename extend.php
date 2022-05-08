<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use DuRoom\Api\Controller\AbstractSerializeController;
use DuRoom\Api\Controller\ListPostsController;
use DuRoom\Api\Controller\ShowDiscussionController;
use DuRoom\Api\Controller\ShowPostController;
use DuRoom\Api\Serializer\CurrentUserSerializer;
use DuRoom\Api\Serializer\ForumSerializer;
use DuRoom\Api\Serializer\PostSerializer;
use DuRoom\Extend;
use DuRoom\Flags\Access\ScopeFlagVisibility;
use DuRoom\Flags\AddCanFlagAttribute;
use DuRoom\Flags\AddFlagsApiAttributes;
use DuRoom\Flags\AddNewFlagCountAttribute;
use DuRoom\Flags\Api\Controller\CreateFlagController;
use DuRoom\Flags\Api\Controller\DeleteFlagsController;
use DuRoom\Flags\Api\Controller\ListFlagsController;
use DuRoom\Flags\Api\Serializer\FlagSerializer;
use DuRoom\Flags\Flag;
use DuRoom\Flags\Listener;
use DuRoom\Flags\PrepareFlagsApiData;
use DuRoom\Forum\Content\AssertRegistered;
use DuRoom\Post\Event\Deleted;
use DuRoom\Post\Post;
use DuRoom\User\User;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less')
        ->route('/flags', 'flags', AssertRegistered::class),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Routes('api'))
        ->get('/flags', 'flags.index', ListFlagsController::class)
        ->post('/flags', 'flags.create', CreateFlagController::class)
        ->delete('/posts/{id}/flags', 'flags.delete', DeleteFlagsController::class),

    (new Extend\Model(User::class))
        ->dateAttribute('read_flags_at'),

    (new Extend\Model(Post::class))
        ->hasMany('flags', Flag::class, 'post_id'),

    (new Extend\ApiSerializer(PostSerializer::class))
        ->hasMany('flags', FlagSerializer::class)
        ->attribute('canFlag', AddCanFlagAttribute::class),

    (new Extend\ApiSerializer(CurrentUserSerializer::class))
        ->attribute('newFlagCount', AddNewFlagCountAttribute::class),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(AddFlagsApiAttributes::class),

    (new Extend\ApiController(ShowDiscussionController::class))
        ->addInclude(['posts.flags', 'posts.flags.user']),

    (new Extend\ApiController(ListPostsController::class))
        ->addInclude(['flags', 'flags.user']),

    (new Extend\ApiController(ShowPostController::class))
        ->addInclude(['flags', 'flags.user']),

    (new Extend\ApiController(AbstractSerializeController::class))
        ->prepareDataForSerialization(PrepareFlagsApiData::class),

    (new Extend\Settings())
        ->serializeToForum('guidelinesUrl', 'duroom-flags.guidelines_url'),

    (new Extend\Event())
        ->listen(Deleted::class, Listener\DeleteFlags::class),

    (new Extend\ModelVisibility(Flag::class))
        ->scope(ScopeFlagVisibility::class),

    new Extend\Locales(__DIR__.'/locale'),
];
