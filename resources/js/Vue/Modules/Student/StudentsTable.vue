<template>
    <div class="vue-component" id="students-table">
        <DynamicTable :route-source="routeSource" :columns="columns" :initial-sorting="sorting" :enable-search="true"
                      ref="table" :id="'students'">
            <template #region.name="{ row }">
                {{ row.region.name }}
            </template>
            <template #phoneNumber="{ row }">
                {{ row.phoneNumber }}
            </template>
            <template v-slot:actions="{ row }">
                <a class="btn text-primary me-2"
                   @click="openModal('modal', row)"
                   href="javascript:void(0)"
                   :title="$t('View details')">
                    <i class="fa-duotone fa-eye"></i>
                </a>
                <a class="btn border-warning text-black"
                   @click="resendButton(row.id)"
                   href="javascript:void(0)"
                   :title="$t('Re-send invitation')">
                    <i class="fa-duotone fa-rotate-right"></i>
                </a>
            </template>
        </DynamicTable>

        <div class="modal" ref="modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            {{ $t('User details') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div v-if="entry" class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="control-label">{{ $t('Name') }}</label>
                                    <input type="text" readonly class="form-control-plaintext" id="name"
                                           :value="entry.fullName">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="control-label">{{ $t('Phone number') }}</label>
                                    <a :href="'tel:' + entry.phoneNumber" class="form-control-plaintext">
                                        {{ entry.phoneNumber }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="control-label">{{ $t('Date of birth') }}</label>
                                    <input type="text" readonly class="form-control-plaintext" id="dob"
                                           :value="entry.date_of_birth + ' (' + entry.age + ')'">
                                </div>
                            </div>
                            <div class="col">
                                <label class="control-label">{{ $t('Gender') }}</label>
                                <div class="form-control-plaintext" id="gender">
                                    {{ entry.gender }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="control-label">{{ $t('Region') }}</label>
                                <div class="form-control-plaintext" id="region">
                                    {{ entry.region.name }}
                                </div>
                            </div>
                            <div class="col">
                                <label class="control-label">{{ $t('District') }}</label>
                                <div class="form-control-plaintext" id="district">
                                    {{ entry.district.name }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="control-label">{{ $t('Institution') }}</label>
                                <div class="form-control-plaintext" id="institution">
                                    {{ entry.institution.name }}
                                </div>
                            </div>
                            <div class="col">
                                <label class="control-label">{{ $t('Grade') }}</label>
                                <div class="form-control-plaintext" id="grade">
                                    {{ entry.grade }}
                                </div>
                            </div>
                        </div>
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
                    name: this.$t('First name'),
                    slug: 'first_name',
                    sortable: true
                },
                {
                    name: this.$t('Last name'),
                    slug: 'last_name',
                    sortable: true
                },
                {
                    name: this.$t('Region'),
                    slug: 'region.name',
                    sortable: true
                },
                {
                    name: this.$t('Phone number'),
                    slug: 'phoneNumber',
                    sortable: false
                }
            ]
        };
    },
    methods: {
        resendButton(studentId) {
            this.$backend.post(this.routeResend, {
                payload: {
                    student_id: studentId
                },
                fail: (response) => {
                    toastr.info(response.message);
                },
                success: (response) => {
                    toastr.info(response.message);
                }
            });
        }
    },
    mixins: [
        ModalMixin,
        TableMixin
    ],
    props: {
        routeResend: {
            required: true,
            type: String
        }
    }
}
</script>
