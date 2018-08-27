<template>
    <div >
        <div class="question">
            <h2 class="question__headline">{{ question.question }}</h2>
        </div>
        <ul class="answers l-question">
            <li class="answers__item" v-for="answer in question.answers">
                <AnswerItem :answer="answer" :on-answered="onAnswerPicked"/>
            </li>
        </ul>
        <button class="btn" @click="onAnswered">Nākošais jautājums</button>
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