
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';



import toastr from 'toastr';
window.toastr = toastr;

import Swal from 'sweetalert2'
window.Swal = Swal;

import select2 from 'select2';
select2($)

import mapboxgl from 'mapbox-gl';
window.mapboxgl = mapboxgl;

import moment from 'moment';
window.moment = moment;

import PureCounter from "@srexi/purecounterjs";
window.PureCounter = PureCounter;

import Quill from "quill";
window.Quill = Quill;

import "owl.carousel"









/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */
 import './echo';
