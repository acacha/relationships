import moment from 'moment';

let toLaravelDate = date => {
  return moment.utc(date, window.acacha_relationships.config.momentDateFormat).
  format(window.acacha_relationships.config.laravelDateFormat)
}

let fromLaravelDate = date => {
  return moment.utc(date).format(window.acacha_relationships.config.momentDateFormat)
}

export { toLaravelDate, fromLaravelDate}