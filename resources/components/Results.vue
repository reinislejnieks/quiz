<template>
    <div class="l-main main" v-if="results">
        <div>
             <div class="intro">{{ results }}</div>
            <button class="btn" @click="restart">Pildīt citu testu</button>
        </div>
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