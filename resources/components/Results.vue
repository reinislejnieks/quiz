<template>
    <div v-if="results">
         <div>{{ results }}</div>
        <button @click="restart">Start again</button>
    </div>
</template>
<script>
    import {mapActions} from 'vuex';

    export default {
        name: 'Results',
        computed: {
            results: {
                get(){
                    return this.$store.state.result;
                }
            }
        },
        methods: mapActions(['restart']),
    }
</script>