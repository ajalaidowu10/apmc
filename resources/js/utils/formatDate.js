import { DateTime } from 'luxon';

function formatDate(date) {
  return DateTime.fromISO(date).toFormat('dd MMM, yyyy');
}

export default formatDate;
