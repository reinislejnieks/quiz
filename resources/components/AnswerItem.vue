<template>
    <a href="#" @click="onAnswerPicked">{{ answer.answer }}</a>
</template>
<script>
    import Answer from '../models/model.answer.js';
    export default {
        name: 'ActionItem',
        props: {
            answer: {
                type: Answer,
                required: true,

            },
            onAnswered: {
                type: Function,
                required: true,
            }
        },
        methods: {
            onAnswerPicked(){
                this.onAnswered(this.answer.id);
            }
        }
    }
</script>