const ModalMixin = {
    data() {
        return {
            entry: null,
            modal: null
        };
    },
    methods: {
        closeModal(ref) {
            this.modal.hide();
            this.entry = null;
        },
        openModal(ref, entry) {
            this.entry = entry;
            if (this.$refs[ref]) {
                this.modal = new window.Modal(this.$refs[ref]);
                this.modal.show();
            }
        }
    }
};

export default ModalMixin;
