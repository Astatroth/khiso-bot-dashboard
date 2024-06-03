<template>
    <div class="vue-component spinner-component" :id="'spinner-component-' + this._uid">
        <div class="spinner-component--spinner"
             :style="'margin:' + margin + ' auto; width:' + width + 'px; height:' + height + 'px; background: conic-gradient(#0000 10%, ' + backgroundColor + ');'"></div>
    </div>
</template>

<script>
export default {
    props: {
        backgroundColor: {
            type: String,
            required: false,
            default: '#007bff'
        },
        height: {
            type: Number,
            required: false,
            default: 24
        },
        margin: {
            required: false,
            type: String,
            default: '25%'
        },
        width: {
            type: Number,
            required: false,
            default: 24
        },
    }
}
</script>

<style scoped>
.spinner-component--spinner {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    -webkit-mask: radial-gradient(farthest-side, #0000 calc(100% - 9px), #000 0);
    animation: spinner-zp9dbg 1s infinite linear;
}

@keyframes spinner-zp9dbg {
    to {
        transform: rotate(1turn);
    }
}
</style>
