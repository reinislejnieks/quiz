<template>
    <div v-if="results">
        {{ results }}
    </div>
</template>
<script>
    export default {
        name: 'Results',
        computed: {
            results: {
                get(){
                    return this.$store.state.result;
                }
            }
        }
    }
</script>