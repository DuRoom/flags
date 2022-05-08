<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Flags\Command;

use DuRoom\Flags\Event\Created;
use DuRoom\Flags\Flag;
use DuRoom\Foundation\ValidationException;
use DuRoom\Post\CommentPost;
use DuRoom\Post\PostRepository;
use DuRoom\Settings\SettingsRepositoryInterface;
use DuRoom\User\Exception\PermissionDeniedException;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Arr;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tobscure\JsonApi\Exception\InvalidParameterException;

class CreateFlagHandler
{
    /**
     * @var PostRepository
     */
    protected $posts;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @param PostRepository $posts
     * @param TranslatorInterface $translator
     * @param SettingsRepositoryInterface $settings
     * @param Dispatcher $events
     */
    public function __construct(PostRepository $posts, TranslatorInterface $translator, SettingsRepositoryInterface $settings, Dispatcher $events)
    {
        $this->posts = $posts;
        $this->translator = $translator;
        $this->settings = $settings;
        $this->events = $events;
    }

    /**
     * @param CreateFlag $command
     * @return Flag
     * @throws InvalidParameterException
     * @throws ValidationException
     */
    public function handle(CreateFlag $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $postId = Arr::get($data, 'relationships.post.data.id');
        $post = $this->posts->findOrFail($postId, $actor);

        if (! ($post instanceof CommentPost)) {
            throw new InvalidParameterException;
        }

        $actor->assertCan('flag', $post);

        if ($actor->id === $post->user_id && ! $this->settings->get('duroom-flags.can_flag_own')) {
            throw new PermissionDeniedException();
        }

        if (Arr::get($data, 'attributes.reason') === null && Arr::get($data, 'attributes.reasonDetail') === '') {
            throw new ValidationException([
                'message' => $this->translator->trans('duroom-flags.forum.flag_post.reason_missing_message')
            ]);
        }

        Flag::unguard();

        $flag = Flag::firstOrNew([
            'post_id' => $post->id,
            'user_id' => $actor->id
        ]);

        $flag->post_id = $post->id;
        $flag->user_id = $actor->id;
        $flag->type = 'user';
        $flag->reason = Arr::get($data, 'attributes.reason');
        $flag->reason_detail = Arr::get($data, 'attributes.reasonDetail');
        $flag->created_at = time();

        $flag->save();

        $this->events->dispatch(new Created($flag, $actor, $data));

        return $flag;
    }
}
