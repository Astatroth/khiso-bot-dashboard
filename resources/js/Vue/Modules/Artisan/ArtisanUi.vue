<template>
    <div class="vue-component" id="artisan-gui">
        <template v-if="!commandsLength">
            <div class="alert alert-warning">
                {{ $t('There are no available commands.') }}
            </div>
        </template>
        <template v-else>
            <div class="row align-items-center">
                <div class="col-auto">
                    <select v-model="command" id="command" class="form-select me-3"
                            :disabled="isRunning">
                        <option value="0">
                            -- {{ $t('Select a command') }} --
                        </option>
                        <option v-for="(command, c) in commands" :value="command.signature">
                            {{ c }} - {{ command.description }}
                        </option>
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-success" type="button" :disabled="isRunning || !command"
                            @click="executeCommand">
                        <i class="fa-duotone fa-square-terminal fa-fw" v-if="!isRunning"></i>
                        <i class="fa-duotone fa-spinner-third fa-spin fa-fw" v-if="isRunning"></i>
                        {{ $t('Execute') }}
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <pre v-html="result"></pre>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    computed: {
        commandsLength() {
            return Object.keys(this.commands).length;
        }
    },
    data() {
        return {
            command: 0,
            isRunning: false,
            result: null
        };
    },
    methods: {
        executeCommand() {
            this.$backend.post(this.routeExecute, {
                before: () => {
                    this.result = null;
                    this.isRunning = true;
                },
                done: () => {
                    this.isRunning = false;
                },
                success: response => {
                    this.result = response.result;
                },
                payload: {
                    commandSignature: this.command
                }
            });
        }
    },
    props: {
        commands: {
            required: false,
            type: Object,
            default: () => {
                return {};
            }
        },
        routeExecute: {
            required: true,
            type: String
        }
    }
}
</script>
