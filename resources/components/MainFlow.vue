<template>
    <div v-if="activeQuestion">
        <div>Hello, {{name}}!</div>
        <QuestionItem />
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