window._ = require('lodash');
window.$ = window.jQuery = require('jquery');

window.Prism = require('prismjs');
require('@claviska/jquery-minicolors');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

require('./additions');
