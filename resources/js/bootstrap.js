import Prism from 'prismjs';
import axios from 'axios'

if (typeof window !== 'undefined') {
    // Globalize Axios
    window.axios = axios;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    // Syntax Highlights
    Prism.highlightAll();
}
