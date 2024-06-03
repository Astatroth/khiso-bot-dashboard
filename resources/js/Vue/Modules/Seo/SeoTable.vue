<template>
    <div class="vue-component" id="seo-table-component">
        <div id="user-filters" class="container-fluid mb-3">
            <div class="row align-items-center">
                <div class="col-auto">
                    <label class="sr-only" for="language">{{ $t('Language') }}</label>
                    <select v-model="filters.language" id="language" class="form-select form-control me-3" @change="applyFilters">
                        <option value="0">
                            -- {{ $t('Any language') }} --
                        </option>
                        <option v-for="(language, l) in languages" :value="l">
                           {{ language.native }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <DynamicTable :route-source="routeSource" :columns="columns" :initial-sorting="sorting" :enable-search="true"
                       ref="table" :id="'seo'">
            <template v-slot:path="{ row }">
                <a :href="row.path" target="_blank">
                    {{ row.path }}
                </a>
            </template>
            <template v-slot:content_type="{ row }">
                {{ row.content_type || '-' }}
            </template>
            <template v-slot:language="{ row }">
                {{ languages[row.language].native }}
            </template>
            <template v-slot:actions="{ row }">
                <a class="btn text-primary me-2"
                   :href="routeEdit.replace(':id', row.id)"
                   :title="$t('buttons.edit')">
                    <i class="fa-duotone fa-pen"></i>
                </a>
                <a href="javascript:void(0)" class="btn text-danger"
                   @click="openModal('delete_modal', row)"
                   :title="$t('buttons.delete')">
                    <i class="fa-duotone fa-trash"></i>
                </a>
            </template>
        </DynamicTable>

        <div class="modal" ref="delete_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            {{ $t('modals.header') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            {{ $t('modals.body') }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                @click="closeModal('delete_modal')" :disabled="isDeleting">
                            <i class="fas fa-times fa-fw"></i>
                            {{ $t('buttons.cancel') }}
                        </button>
                        <button type="button" class="btn btn-danger" @click="submitDelete" :disabled="isDeleting">
                            <i class="fa-duotone fa-fw fa-trash" v-if="!isDeleting"></i>
                            <i class="fa-duotone fa-fw fa-spinner-third fa-spin" v-if="isDeleting"></i>
                            {{ $t('buttons.delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableMixin from "src/Vue/Mixins/TableMixin";
import ModalMixin from "src/Vue/Mixins/ModalMixin";

export default {
    data() {
        return {
            columns: [
                {
                    name: 'ID',
                    slug: 'id',
                    sortable: true,
                    width: 75
                },
                {
                    name: this.$t('Path'),
                    slug: 'path',
                    sortable: true
                },
                {
                    name: this.$t('Language'),
                    slug: 'language',
                    sortable: true,
                    width: 150
                }
            ],
            filters: {
                language: 0
            },
            languages: window.supportedLocales,
        };
    },
    methods: {

    },
    mixins: [
        TableMixin,
        ModalMixin
    ]
}
</script>
