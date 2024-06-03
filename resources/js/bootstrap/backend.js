/**
 * POST to create a resource
 * GET to read a resource or collection of resources
 * PUT to update/replace a resource
 * PATCH to update/modify a resource
 * DELETE to destroy a resource
 */
export default class Backend {
    i18n = null;

    constructor(i18n) {
        this.i18n = i18n;
    }
    get(url, options) {
        this.request('get', url, options);
    }
    post(url, options) {
        this.request('post', url, options);
    }
    put(url, options) {
        this.request('put', url, options);
    }
    patch(url, options) {
        this.request('patch', url, options);
    }
    delete(url, options) {
        this.request('delete', url, options);
    }
    request(method, url, options = {}) {
        axios.interceptors.request.clear();
        let _options = {
            method: method,
            url: url
        };

        if (options.payload) {
            if (method === 'get') {
                _options.url += "?" + this.implodeRequestParameters(options.payload);
            } else {
                _options.data = options.payload;
            }
        }

        if (options.headers) {
            _options.headers = options.headers;
        }

        if (typeof options.before === 'function') {
            axios.interceptors.request.use((config) => {
                options.before();

                return config;
            });
        }

        axios(_options)
        .then(response => {
            if (options.success && typeof options.success === 'function') {
                options.success(response.data);
            }
        })
        .catch(error => {
            if (error.response.status) {
                switch (error.response.status) {
                    case 419:
                        window.location.reload();
                        break;
                    case 400:
                    case 406:
                        toastr.error(error.response.data.message);

                        break;
                    case 405:
                    case 422:
                        for (let message in error.response.data.errors) {
                            toastr.error(error.response.data.errors[message]);
                        }
                        break;
                    case 500:
                    default:
                        toastr.error(this.i18n.t('status.server_error'));
                        break;
                }
            }

            if (typeof options.fail === 'function') {
                options.fail(error.response);
            }
        })
        .finally(() => {
            if (options.done && typeof options.done === 'function') {
                options.done();
            }
        });
    }
    implodeRequestParameters(payload) {
        return new URLSearchParams(payload);
    }
}
