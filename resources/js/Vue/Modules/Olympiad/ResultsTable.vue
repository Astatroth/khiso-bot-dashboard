<template>
    <div class="vue-component" id="results-table">
        <DynamicTable v-if="isMounted" :route-source="routeSource" :columns="columns" :initial-sorting="sorting"
                      :enable-search="false" :filters="filters"
                      ref="table" :id="'results'">
            <template #time="{ row }">
                {{ $t('{min} minutes', {min: row.time}) }}
            </template>
            <template v-slot:actions="{ row }">
                <a class="btn text-primary me-2"
                   :href="routeView.replace(':id', row.id)"
                   :title="$t('buttons.edit')">
                    <i class="fa-duotone fa-eye"></i>
                </a>
            </template>
        </DynamicTable>
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
                    name: this.$t('Name'),
                    slug: 'fullname',
                    sortable: true
                },
                {
                    name: this.$t('Score'),
                    slug: 'score',
                    sortable: true
                },
                {
                    name: this.$t('Time spent'),
                    slug: 'time',
                    sortable: true
                }
            ],
            filters: {
                olympiadId: 0
            },
            isMounted: false,
            sorting: {
                column: 'score',
                order: 'desc'
            }
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
        },
        routeView: {
            required: true,
            type: String
        }
    }
}
</script>
