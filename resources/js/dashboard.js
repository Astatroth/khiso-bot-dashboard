import './bootstrap/axios.js';
import './bootstrap/string.js';
import './bootstrap/toastr.js';

import { transliterate as tr } from 'transliteration';
window.tr = tr;

import { Modal } from 'bootstrap';
window.Modal = Modal;
