<template>
    <div class="vue-component container-fluid dynamic-table-wrapper" :id="'dynamic-table-component-' + componentId">
        <!-- Search -->
        <div v-if="enableSearch" class="row">
            <div class="col">
                <div class="datatable-filter d-flex align-items-start">
                    <div class="input-group me-3">
                        <div class="input-group-text">
                            <i class="fa-duotone fa-search"></i>
                        </div>
                        <input type="search" v-model="search" class="form-control"
                               :placeholder="searchPlaceholder || $t('Start typing...')">
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-secondary dropdown-toggle" id="dynamic-table--reset"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-duotone fa-fw fa-refresh me-1"></i>{{ $t('Reset') }}
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" @click="removeCookie('.search')">
                                    {{ $t('Search') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" @click="removeCookie('.sorting')">
                                    {{ $t('Sorting') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" @click="removeCookie('.page')">
                                    {{ $t('Page') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" @click="resetCookies()">
                                    {{ $t('All') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="row">
            <div class="col table-responsive">
                <template v-if="loading">
                    <loading-overlay></loading-overlay>
                </template>
                <template v-if="!loading">
                    <table class="table dynamic-table table-striped table-hover table-white-space mt-3" role="table">
                        <thead>
                        <tr role="row">
                            <th v-for="(column, c) in columns" :key="c" :class="sortingClass(column)"
                                :style="{width: columnWidth(column)}" @click="sort(column)">
                                <template>
                                    {{ column.name }}

                                    <template v-if="typeof column.sortable !== 'undefined' && column.sortable !== false">
                                        <i class="fal fa-long-arrow-up"></i>
                                        <i class="fal fa-long-arrow-down"></i>
                                    </template>
                                </template>
                            </th>
                            <th v-if="showActions" class="text-end" style="min-width: 150px;">
                                {{ $t('Actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="position-relative">
                        <template v-if="!loading && total > 0">
                            <tr v-for="(row, r) in rows" :key="r" class="align-middle">
                                <td v-for="(column, c) in columns" :key="c">
                                    <slot :name="column.slug" :row="row">
                                        <span v-html="row[column.slug]"></span>
                                    </slot>
                                </td>
                                <td v-if="showActions" class="text-end" style="min-width: 150px;">
                                    <slot name="actions" :row="row"></slot>
                                </td>
                            </tr>
                        </template>
                        <template v-if="!loading && total === 0">
                            <tr>
                                <td :colspan="columns.length + (showActions ? 1 : 0)" class="text-center py-2">
                                    {{ $t('Nothing found') }}
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </template>
            </div>
        </div>

        <!-- Table stats and pagination -->
        <div v-if="!loading" class="row">
            <div class="col-sm-12 col-md-5">
                <div v-if="total > 1" class="datatable-info" role="status" aria-live="polite">
                    {{ $t('Showing {from} to {to} of {count} rows', {from: (page - 1) * limit + 1, to: (page - 1) * limit + rows.length, count: total}) }}
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dynamic-table--paginate paging-simple-numbers">
                    <paginate
                        v-if="pages > 1"
                        v-model="page"
                        :page-count="pages"
                        :page-range="5"
                        :margin-pages="2"
                        :click-handler="changePage"
                        :prev-text="'<span class=&quot;la la-angle-double-left&quot;></span>'"
                        :next-text="'<span class=&quot;la la-angle-double-right&quot;></span>'"
                        :container-class="'pagination pagination-expanded justify-content-end'"
                        :page-class="'page-item'"
                        :page-link-class="'page-link'">
                    </paginate>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
#dynamic-table--reset {
    flex: 1 0 7%;
}
.dynamic-table .sorting {
    position: relative;
    cursor: pointer;
}
.dynamic-table .sorting i {
    position: absolute;
    bottom: .9em;
    display: block;
    opacity: .3;
}
.dynamic-table .sorting i.fa-long-arrow-up {
    right: 1em;
}
.dynamic-table .sorting i.fa-long-arrow-down {
    right: .5em;
}
.dynamic-table .sorting.sorting_asc .fa-long-arrow-up, .dynamic-table .sorting.sorting_desc .fa-long-arrow-down {
    opacity: 1;
}
</style>

<script>
import LoadingOverlay from "./LoadingOverlay.vue";
import Paginate from 'vuejs-paginate';

export default {
    components: {
        LoadingOverlay,
        Paginate
    },
    data() {
        return {
            cookieConfig: {
                name: null,
                expiresIn: null
            },
            componentId: null,
            loading: false,
            page: 1,
            pages: 0,
            rows: [],
            search: null,
            sorting: {
                column: 'id',
                order: 'desc'
            },
            total: 0
        };
    },
    methods: {
        changePage(page) {
            this.page = page;

            this.setCookie('.page', page);

            this.loadData();
        },
        columnWidth(column) {
            return column.width ? column.width + 'px' : false;
        },
        getCookie(name) {
            return this.$cookies.get(this.cookieConfig.name + name);
        },
        loadData(filters = null) {
            this.$backend.post(this.routeSource, {
                before: () => {
                    this.loading = true;
                },
                done: () => {
                    this.loading = false;
                },
                success: response => {
                    this.rows = response.rows;
                    this.total = response.total;
                    this.pages = Math.ceil(response.total / this.limit);

                    this.$emit('loaded', this.rows);
                },
                payload: {
                    filters: filters !== null ? filters : this.filters,
                    page: this.page,
                    limit: this.limit,
                    search: this.search,
                    sorting: this.sorting
                }
            });
        },
        removeCookie(name) {
            this.$cookies.remove(this.cookieConfig.name + name);
            switch (name) {
                case '.search':
                    this.search = null;
                    break;
                case '.sorting':
                    this.sorting = this.initialSorting;
                    break;
                case '.page':
                    this.page = 1;
                    break;
                default:
                    break;
            }

            this.loadData();
        },
        resetCookies() {
            this.removeCookie('.search');
            this.removeCookie('.page');
            this.removeCookie('.sorting');

            this.search = null;
            this.page = 1;
            this.sorting = this.initialSorting;

            this.loadData();
        },
        setCookie(name, value, expiresIn = null) {
            this.$cookies.set(
                this.cookieConfig.name + name,
                value,
                expiresIn || this.cookieConfig.expiresIn
            );
        },
        sort(column) {
            if (
                (typeof column.sortable !== 'undefined' && column.sortable === false)
                || typeof column.sortable === 'undefined'
            ) {
                return false;
            }

            if (column.slug === this.sorting.column) {
                if (this.sorting.order === 'asc') {
                    this.sorting.order = 'desc';
                } else {
                    this.sorting.order = 'asc';
                }
            } else {
                this.sorting.column = column.slug;
                this.sorting.order = 'asc';
            }

            this.setCookie('.sorting', this.sorting);

            this.loadData();
        },
        sortingClass(column) {
            let _class = 'sorting';

            if (typeof column.sortable !== 'undefined' && column.sortable === false) {
                return false;
            }

            if (this.sorting.column === column.slug) {
                if (this.sorting.order === 'asc') {
                    _class += ' sorting_asc';
                } else {
                    _class += ' sorting_desc';
                }
            }

            return _class;
        }
    },
    mounted() {
        this.componentId = this._uid;

        let cookieConfig = window.datatableCookieConfig;
        cookieConfig.name += this.id + '_dynamic_table';
        this.cookieConfig = cookieConfig;

        this.search = this.getCookie('.search') || null;
        this.page = this.getCookie('.page') || 1;
        this.sorting = this.getCookie('.sorting') || this.initialSorting;

        if (!this.defer) {
            this.loadData();
        }
    },
    props: {
        columns: {
            required: true,
            type: Array
        },
        defer: {
            required: false,
            type: Boolean,
            default: () => {
                return false;
            },
        },
        enableSearch: {
            required: false,
            type: Boolean,
            default: () => {
                return false;
            }
        },
        id: {
            required: true,
            type: String
        },
        initialSorting: {
            required: false,
            type: Object,
            default: () => {
                return {
                    column: 'id',
                    order: 'desc'
                };
            }
        },
        filters: {
            required: false,
            type: Object,
            default: () => {
                return {};
            }
        },
        limit: {
            required: false,
            type: Number,
            default: 25
        },
        routeSource: {
            required: true,
            type: String
        },
        searchPlaceholder: {
            required: false,
            type: String,
            default: null
        },
        showActions: {
            required: false,
            type: Boolean,
            default: () => {
                return true;
            }
        }
    },
    watch: {
        search() {
            if (this.search !== null && (this.search.length >= 3 || this.search.length === 0)) {
                if (this.search.length >= 3) {
                    this.setCookie('.search', this.search);
                } else {
                    this.removeCookie('.search');
                }
                this.filters.page = 1;
                this.page = 1;
                this.loadData(this.filters);
            }
        }
    }
}
</script>
