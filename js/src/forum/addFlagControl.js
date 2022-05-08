import { extend } from 'duroom/common/extend';
import app from 'duroom/forum/app';
import PostControls from 'duroom/forum/utils/PostControls';
import Button from 'duroom/common/components/Button';

import FlagPostModal from './components/FlagPostModal';

export default function () {
  extend(PostControls, 'userControls', function (items, post) {
    if (post.isHidden() || post.contentType() !== 'comment' || !post.canFlag()) return;

    items.add(
      'flag',
      <Button icon="fas fa-flag" onclick={() => app.modal.show(FlagPostModal, { post })}>
        {app.translator.trans('duroom-flags.forum.post_controls.flag_button')}
      </Button>
    );
  });
}
