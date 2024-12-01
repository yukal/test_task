import axios from 'axios';
window.axios = axios;

import preline from 'preline/preline';
window.preline = preline;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
