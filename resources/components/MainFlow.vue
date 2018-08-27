<template>
    <div class="l-main main" v-if="activeQuestion">
        <div >
            <div class="hello">Sveiks, {{name}}!</div>
            <QuestionItem />
        </div>
    </div>
</template>

<script>
    import QuestionItem from './QuestionItem';
    export default {
        name: 'MainFlow',
        components: {QuestionItem},
        computed: {
            name: {
                get() {
                    return this.$store.state.name;
                }
            },
            activeQuestion: {
                get() {
                    return this.$store.state.activeQuestion;
                }
            },
        }
    }
</script>