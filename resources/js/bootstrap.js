import axios from 'axios'

// Need to check for 'window' since it is unavailable during SSR
if (typeof window !== 'undefined') {
    // Globalize Axios
    window.axios = axios;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}
