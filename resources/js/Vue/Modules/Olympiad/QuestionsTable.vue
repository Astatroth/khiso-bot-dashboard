<template>
    <div class="vue-component" id="questions-table">
        <DynamicTable v-if="isMounted" :route-source="routeSource" :columns="columns" :initial-sorting="sorting"
                      :enable-search="true" :filters="filters"
                      ref="table" :id="'questions'">
            <template v-slot:actions="{ row }">
                <a class="btn text-primary me-2"
                   :href="routeEdit.replace(':olympiad', row.olympiad_id).replace(':id', row.id)"
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
                    name: this.$t('title'),
                    slug: 'title',
                    sortable: true
                }
            ],
            filters: {
                olympiadId: 0
            },
            isMounted: false
        };
    },
    mixins: [
        ModalMixin,
        TableMixin
    ],
    mounted() {
        this.filters.olympiadId = this.olympiadId;
        this.isMounted = true;
    },
    props: {
        olympiadId: {
            required: true,
            type: Number
        }
    }
}
</script>
