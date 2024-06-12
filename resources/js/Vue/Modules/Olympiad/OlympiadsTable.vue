<template>
    <div class="vue-component" id="olympiads-table">
        <div id="news-filters" class="container-fluid mb-3">
            <div class="row align-items-center">
                <div class="col-auto">
                    <label class="sr-only" for="status-filter">{{ $t('Status') }}</label>
                    <select v-model="filters.status" id="status-filter" class="form-select me-3"
                            @change="applyFilters">
                        <option value="any">
                            {{ $t('Any status') }}
                        </option>
                        <option v-for="(s, i) in statuses" :value="i">
                            {{ s.label }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <DynamicTable :route-source="routeSource" :columns="columns" :initial-sorting="sorting" :enable-search="true"
                      ref="table" :id="'olympiads'">
            <template #title="{ row }">
                <div class="row-container">
                    <div class="image-wrapper">
                        <img :src="row.image.url" class="img-fluid" :alt="row.title" />
                    </div>
                    <div class="text-wrapper">
                        <p class="mb-0">{{ row.title }}</p>
                    </div>
                </div>
            </template>
            <template #status="{ row }">
                <span :class="'badge text-bg-' + row.status.style">
                    {{ row.status.label }}
                </span>
            </template>
            <template v-slot:actions="{ row }">
                <a v-if="row.editingAllowed" class="btn text-warning me-2"
                   :href="routeEdit.replace(':id/edit', row.id + '/question/list')"
                   :title="$t('Questions')">
                    <i class="fa-duotone fa-question"></i>
                </a>
                <a v-if="row.editingAllowed" class="btn text-primary me-2"
                   :href="routeEdit.replace(':id', row.id)"
                   :title="$t('buttons.edit')">
                    <i class="fa-duotone fa-pen"></i>
                </a>
                <a v-if="row.deletionAllowed" href="javascript:void(0)" class="btn text-danger"
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
import ModalMixin from 'src/Vue/Mixins/ModalMixin';
import TableMixin from 'src/Vue/Mixins/TableMixin';

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
                    name: this.$t('Title'),
                    slug: 'title',
                    sortable: true
                },
                {
                    name: this.$t('Status'),
                    slug: 'status',
                    sortable: true,
                    width: 200
                }
            ],
            filters: {
                status: 'any'
            }
        };
    },
    mixins: [
        ModalMixin,
        TableMixin
    ],
    props: {
        statuses: {
            required: true,
            type: Object
        }
    }
}
</script>
