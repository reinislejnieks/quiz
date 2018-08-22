<template>
    <div>
        <h1>{{ question.question }}</h1>
        <ul>
            <li v-for="answer in question.answers">
                <AnswerItem :answer="answer" :on-answered="onAnswerPicked"/>
            </li>
        </ul>
        <button @click="onAnswered">Next question</button>
    </div>
</template>
<script>
    import {mapActions} from "vuex";
    import AnswerItem from "./AnswerItem";


    export default{
        name: 'QuestionItem',
        components: {AnswerItem},
        data(){
            return {
                answerId: null,
            }
        },
        computed: {
            question: {
                get(){
                    return this.$store.state.activeQuestion;
                }
            }
        },
        methods: Object.assign({}, mapActions([
          'answer'
        ]), {
            onAnswerPicked(answerId){
                this.answerId = answerId;
            },
            onAnswered(){
                if(!this.answerId){
                    console.log('no answer picked');
                    return;
                }
                console.log(this.answerId);
                this.answer(this.answerId);
            }
        })
    }
</script>