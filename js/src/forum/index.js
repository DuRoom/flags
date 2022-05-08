import app from 'duroom/forum/app';
import Model from 'duroom/common/Model';

import Flag from './models/Flag';
import FlagsPage from './components/FlagsPage';
import FlagListState from './states/FlagListState';
import addFlagControl from './addFlagControl';
import addFlagsDropdown from './addFlagsDropdown';
import addFlagsToPosts from './addFlagsToPosts';

app.initializers.add('duroom-flags', () => {
  app.store.models.posts.prototype.flags = Model.hasMany('flags');
  app.store.models.posts.prototype.canFlag = Model.attribute('canFlag');

  app.store.models.flags = Flag;

  app.routes.flags = { path: '/flags', component: FlagsPage };

  app.flags = new FlagListState(app);

  addFlagControl();
  addFlagsDropdown();
  addFlagsToPosts();
});

// Expose compat API
import flagsCompat from './compat';
import { compat } from '@duroom/core/forum';

Object.assign(compat, flagsCompat);
