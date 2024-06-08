<template>
    <div class="vue-component" id="telegram-channels-table">
        <DynamicTable :route-source="routeSource" :columns="columns" :initial-sorting="sorting" :enable-search="true"
                      ref="table" :id="'telegram_channels'">
            <template #title="{ row }">
                <a :href="row.url" target="_blank">{{ row.title }}</a>
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
                    name: this.$t('Channel ID'),
                    slug: 'channel_id',
                    sortable: false,
                    width: 150
                }
            ]
        };
    },
    mixins: [
        ModalMixin,
        TableMixin
    ]
}
</script>
