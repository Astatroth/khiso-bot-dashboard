<template>
    <div class="vue-component loading-overlay">
        <spinner :width="56" :height="56" :margin="'5%'"></spinner>

        <div class="loading-overlay--text">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import Spinner from "./Spinner.vue";

export default {
    components: {
        Spinner
    }
}
</script>

<style scoped lang="scss">
.loading-overlay {
    text-align: center;
    padding-top: 5rem;
    padding-bottom: 5rem;
    &--spinner {
        margin: 0 auto;
    }
}
</style>
