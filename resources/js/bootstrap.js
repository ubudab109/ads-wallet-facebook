// Load plugins
import cash from "cash-dom";
import axios from "axios";
import helper from "./helper";
import Velocity from "velocity-animate";
import xlsx from "xlsx";
import feather from "feather-icons";
import * as Popper from "@popperjs/core";


// Set plugins globally
window.cash = cash;
window.axios = axios;
window.helper = helper;
window.Velocity = Velocity;
window.Popper = Popper;
window.XLSX = xlsx;

import Echo from 'laravel-echo'
import Axios from "axios";
window.Vue = require('vue');
window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: false
});

// CSRF token
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    Axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}
