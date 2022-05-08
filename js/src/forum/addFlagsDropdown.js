import { extend } from 'duroom/common/extend';
import app from 'duroom/forum/app';
import HeaderSecondary from 'duroom/forum/components/HeaderSecondary';
import FlagsDropdown from './components/FlagsDropdown';

export default function () {
  extend(HeaderSecondary.prototype, 'items', function (items) {
    if (app.forum.attribute('canViewFlags')) {
      items.add('flags', <FlagsDropdown state={app.flags} />, 15);
    }
  });
}
