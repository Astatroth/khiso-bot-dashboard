<template>
    <div class="vue-component multiple-component position-relative">
        <a href="javascript:void(0);"
           :class="'editable editable--pre-wrapped editable--click' + (!value ? ' editable--empty' : '')"
           :id="'editable_' + this._uid" @click="enable">
            {{ value ?? 'Empty' }}
        </a>
        <div v-if="isEditing" :id="'popover_' + this._uid" class="popover editable--container editable-popup" x-placement="top">
            <div class="arrow" style="left: 125px;"></div>
            <h3 class="popover-header">
                {{ $t('Enter translation') }}
            </h3>
            <div class="popover-body">
                <div class="form-inline editable--form">
                    <div class="control-group form-group">
                        <div>
                            <div class="editable--input">
                                <textarea class="form-control input-large"
                                          rows="7"
                                          v-model="mutatingValue" ref="input" v-on:keyup="onKeyUp"></textarea>
                            </div>
                            <div class="editable--buttons">
                                <button type="submit" class="btn btn-primary btn-sm editable--submit" @click="submit">
                                    <i class="fa-duotone fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm editable--cancel" @click="cancel">
                                    <i class="fa-duotone fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isEditing: false,
            mutatingValue: null
        };
    },
    methods: {
        cancel() {
            this.isEditing = false;
            this.mutatingValue = this.value;
        },
        enable(event) {
            this.isEditing = true;
            this.$nextTick(() => {
                this.$refs.input.focus();
            });
        },
        onKeyUp($event) {
            if ($event.keyCode === 27) {
                this.cancel();
            }
        },
        submit() {
            this.$emit('update', {value: this.mutatingValue});
            this.isEditing = false;
        }
    },
    mounted() {
        this.mutatingValue = this.value;
    },
    props: [
        'value'
    ]
}
</script>

<style scoped lang="scss">
.editable {
    &--container {
        position: absolute;
        bottom: 20px;
        left: -110px;
        &.editable-popup {
            max-width: none !important;
        }
        &.popover {
            width: auto;
        }
    }
    &--pre-wrapped {
        white-space: pre-wrap;
    }
    &--empty, &--empty:hover, &--empty:focus {
        font-style: italic;
        color: #dd1144;
    }
    &--click, &--click:hover {
        text-decoration: none;
        border-bottom: 1px dashed #0088cc;
    }
    &--form {
        margin-bottom: 0;
        .control-group {
            margin-bottom: 0;
            white-space: nowrap;
            line-height: 20px;
        }
    }
    &--input {
        vertical-align: top;
        display: inline-block;
        width: auto;
        white-space: normal;
        zoom: 1;
        textarea {
            height: auto;
        }
    }
    &--buttons {
        display: inline-block;
        vertical-align: top;
        margin-left: 7px;
        zoom: 1;
    }
    &--cancel {
        margin-left: 7px;
    }
}
.popover {
    .arrow {
        position: absolute;
        display: block;
        width: 1rem;
        height: 0.5rem;
        margin: 0 0.3rem;
        &:before, &:after {
            position: absolute;
            display: block;
            content: "";
            border-color: transparent;
            border-style: solid;
        }
    }
}
.popover[x-placement=top] {
    margin-top: -10px;
    &>.arrow {
        bottom: calc(-.5rem - 1px);
        &:before {
            bottom: 0;
            border-width: 0.5rem 0.5rem 0;
            border-top-color: rgba(0,0,0,.25);
        }
        &:after {
            bottom: 1px;
            border-width: 0.5rem 0.5rem 0;
            border-top-color: #fff;
        }
    }
}
</style>
