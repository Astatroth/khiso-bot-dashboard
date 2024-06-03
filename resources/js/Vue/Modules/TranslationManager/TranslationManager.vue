<template>
    <div class="vue-component" id="translation-manager">
        <div id="translation-filter" class="container-fluid mb-3">
            <div class="row align-items-center">
                <div class="col-auto">
                    <select v-model="group"
                            id="group"
                            class="form-select form-control"
                            :disabled="isLoadingGroups || (!isLoadingGroups && !groupsLength)"
                            @change="applyFilters">
                        <option value="all">-- {{ $t('All translation groups')}} --</option>
                        <option v-for="(group, g) in groups" :key="g" :value="group">
                            {{ $t('common.translation_groups.' + group) }}
                        </option>
                    </select>
                </div>
                <div class="col-auto">
                    <div class="btn-group">
                        <button class="btn btn-success" type="button" :disabled="isSettingUp" @click="setup(0)">
                            <i class="fa-duotone fa-fw fa-upload" v-if="!isSettingUp"></i>
                            <i class="fa-duotone fa-fw fa-spinner-third fa-spin" v-if="isSettingUp"></i>
                            {{ setupText }}
                        </button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" @click="setup(0)">
                                    {{ $t('Append new translations') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" @click="setup(1)">
                                    {{ $t('Replace existing translations') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="btn-group">
                        <button class="btn btn-primary" type="button" :disabled="isPublishing" @click="publish(0)">
                            <i class="fa-duotone fa-fw fa-download" v-if="!isPublishing"></i>
                            <i class="fa-duotone fa-fw fa-spinner-third fa-spin" v-if="isPublishing"></i>
                            {{ $t('Publish all translations') }}
                        </button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" @click="publish(group)">
                                    {{ $t('Publish selected group') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div class="datatable-filter">
                <div class="input-group">
                    <div class="input-group-text">
                        <i class="fa-duotone fa-search"></i>
                    </div>
                    <input type="search" v-model="search" class="form-control" :placeholder="$t('Start typing...')">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <template v-if="isLoading">
                        <LoadingOverlay></LoadingOverlay>
                    </template>
                    <template v-if="!isLoading">
                        <table class="table datatable table-striped table-hover table-white-space" role="table">
                            <thead>
                            <tr role="row">
                                <th style="width: 15%;">
                                    {{ $t('String key') }}
                                </th>
                                <th v-for="c in columns">
                                    {{ c.name }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="position-relative">
                            <template v-if="!isLoading && translationsLength > 0">
                                <tr v-for="(t, i) in translations">
                                    <td>
                                        {{ i }}
                                    </td>
                                    <td v-for="c in columns">
                                        <x-editable :value="t[c.slug] ? (t[c.slug].value ?? null) : null"
                                                    @update="save(i, c.slug, getGroup(t), $event)"></x-editable>
                                    </td>
                                </tr>
                            </template>
                            <template v-if="!isLoading && translationsLength === 0">
                                <tr>
                                    <td :colspan="columns.length + 1" class="text-center py-2">
                                        {{ $t('Nothing found') }}
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingOverlay from "src/Vue/Components/LoadingOverlay.vue";
import XEditable from "src/Vue/Components/XEditable.vue";

export default {
    components: {
        LoadingOverlay,
        XEditable
    },
    computed: {
        groupsLength() {
            return Object.keys(this.groups).length;
        },
        translationsLength() {
            return Object.keys(this.translations).length;
        }
    },
    data() {
        return {
            columns: [],
            group: 'all',
            groups: [],
            isLoading: false,
            isLoadingGroups: false,
            isPublishing: false,
            isSaving: false,
            isSettingUp: false,
            search: null,
            setupText: this.$t('Import translations'),
            translations: []
        };
    },
    methods: {
        applyFilters() {
            this.loadTranslations();
        },
        getGroup(translation) {
            let group = null;

            Object.keys(translation).forEach((i, k) => {
                if (translation[i].group) {
                    group = translation[i].group;
                }
            });

            return group;
        },
        loadGroups() {
            this.$backend.post(this.routeGroupLoad, {
                before: () => {
                    this.isLoadingGroups = true;
                },
                done: () => {
                    this.isLoadingGroups = false;
                },
                success: response => {
                    this.groups = response.groups;
                    if (this.groups.length === 0) {
                        toastr.error('No translations groups found. Press "Import translations" button.');
                    }
                }
            });
        },
        loadTranslations() {
            this.$backend.post(this.routeLoad, {
                before: () => {
                    this.isLoading = true;
                },
                done: () => {
                    this.isLoading = false;
                },
                success: response => {
                    this.translations = response.translations;
                },
                payload: {
                    group: this.group,
                    search: this.search
                }
            });
        },
        publish(group) {
            this.$backend.post(this.routePublish, {
                before: () => {
                    this.isPublishing = true;
                },
                done: () => {
                    this.isPublishing = false;
                },
                success: () => {
                    toastr.success(this.$t('Successfully published translations.'));
                },
                payload: {
                    group: group !== 0 ? group : null
                }
            });
        },
        save(key, language, group, value) {
            this.$backend.post(this.routeSave, {
                before: () => {
                    this.isSaving = true;
                },
                done: () => {
                    this.isSaving = false;
                },
                success: (response) => {
                    toastr.success(this.$t('Saved translation for "{key}".', {key: key}));
                    this.$set(this.translations[key], response.result.locale, response.result);
                },
                payload: {
                    key: key,
                    value: value.value,
                    language: language,
                    group: group
                }
            });
        },
        setup(replace = 0) {
            this.$backend.post(this.routeImport, {
                before: () => {
                    this.isSettingUp = true;
                    this.setupText = this.$t('Importing translations');
                },
                success: response => {
                    toastr.success(this.$t('Imported {count} translations', {count: response.count}));
                    this.$backend.post(this.routeDiscover, {
                        before: () => {
                            this.setupText = this.$t('Discovering new translations');
                        },
                        done: () => {
                            this.isSettingUp = false;
                        },
                        success: () => {
                            toastr.success(this.$t('Discovered {count} translations', {count: response.count}));
                            this.setupText = this.$t('Import translations');
                            this.loadGroups();
                        }
                    });
                },
                payload: {
                    replace: parseInt(replace)
                }
            });
        }
    },
    mounted() {
        Object.keys(window.supportedLocales).forEach((i, k) => {
            this.columns.push({
                name: i,
                slug: i,
                sortable: false
            });
        });

        this.loadGroups();
    },
    props: {
        routeDiscover: {
            required: true,
            type: String
        },
        routeGroupLoad: {
            required: true,
            type: String
        },
        routeImport: {
            required: true,
            type: String
        },
        routeLoad: {
            required: true,
            type: String
        },
        routePublish: {
            required: true,
            type: String
        },
        routeSave: {
            required: true,
            type: String
        }
    },
    watch: {
        groups() {
            this.loadTranslations();
        },
        search() {
            if (this.search.length >= 3 || this.search.length === 0) {
                this.loadTranslations();
            }
        }
    }
}
</script>
