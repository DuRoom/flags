<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Flags\Api\Controller;

use DuRoom\Api\Controller\AbstractListController;
use DuRoom\Flags\Api\Serializer\FlagSerializer;
use DuRoom\Flags\Flag;
use DuRoom\Http\RequestUtil;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListFlagsController extends AbstractListController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = FlagSerializer::class;

    /**
     * {@inheritdoc}
     */
    public $include = [
        'user',
        'post',
        'post.user',
        'post.discussion'
    ];

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = RequestUtil::getActor($request);
        $include = $this->extractInclude($request);

        $actor->assertRegistered();

        $actor->read_flags_at = time();
        $actor->save();

        $flags = Flag::whereVisibleTo($actor)
            ->latest('flags.created_at')
            ->groupBy('post_id')
            ->get();

        if (in_array('post.user', $include)) {
            $include[] = 'post.user.groups';
        }

        $this->loadRelations($flags, $include);

        return $flags;
    }
}
