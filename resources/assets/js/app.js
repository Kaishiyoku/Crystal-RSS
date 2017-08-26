window._ = require('lodash');
window.$ = window.jQuery = require('jquery');

import Popper from 'popper.js';

window.Popper = Popper;

require('bootstrap');
window.Waves = require('node-waves');
window.Prism = require('prismjs');

require('./additions');