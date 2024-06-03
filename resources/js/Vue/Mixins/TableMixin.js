import DynamicTable from "src/Vue/Components/DynamicTable.vue";

const TableMixin = {
    components: {
        DynamicTable
    },
    data() {
        return {
            columns: [],
            filters: {},
            isDeleting: false,
            sorting: {
                column: 'id',
                order: 'desc'
            }
        };
    },
    methods: {
        applyFilters() {
            this.reload();
        },
        reload() {
            this.$refs['table'].loadData(this.filters);
        },
        submitDelete() {
            this.$backend.post(this.routeDelete, {
                payload: {
                    id: this.entry.id
                },
                before: () => {
                    this.isDeleting = true;
                },
                fail: () => {
                    this.closeModal('delete_modal');
                },
                success: (response) => {
                    toastr.info(response.message);
                    this.closeModal('delete_modal');
                    this.$refs['table'].loadData(this.filters);
                },
                done: () => {
                    this.isDeleting = false;
                }
            });
        },
    },
    props: {
        routeDelete: {
            required: false,
            type: String
        },
        routeEdit: {
            required: false,
            type: String
        },
        routeSource: {
            required: true,
            type: String
        }
    }
};

export default TableMixin;
