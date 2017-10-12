var logSection = document.querySelector('.log');

function log(msg) {
  var htmlTemplate = '-<br><span>{{message}}</span';
  htmlTemplate = htmlTemplate.replace('{{message}}', msg);
  logSection.insertAdjacentHTML('beforeend', htmlTemplate);
}