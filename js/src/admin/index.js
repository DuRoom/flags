import app from 'duroom/admin/app';

app.initializers.add('duroom-flags', () => {
  app.extensionData
    .for('duroom-flags')
    .registerSetting(
      {
        setting: 'duroom-flags.guidelines_url',
        type: 'text',
        label: app.translator.trans('duroom-flags.admin.settings.guidelines_url_label'),
      },
      15
    )
    .registerSetting({
      setting: 'duroom-flags.can_flag_own',
      type: 'boolean',
      label: app.translator.trans('duroom-flags.admin.settings.flag_own_posts_label'),
    })
    .registerPermission(
      {
        icon: 'fas fa-flag',
        label: app.translator.trans('duroom-flags.admin.permissions.view_flags_label'),
        permission: 'discussion.viewFlags',
      },
      'moderate',
      65
    )

    .registerPermission(
      {
        icon: 'fas fa-flag',
        label: app.translator.trans('duroom-flags.admin.permissions.flag_posts_label'),
        permission: 'discussion.flagPosts',
      },
      'reply',
      65
    );
});
