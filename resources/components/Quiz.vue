<template>
    <div class="wrap">
        <div class="header l-header">
            <div class="logo">
                <Logo/>
            </div>
            <div class="login">
                <a class="link" href="#">Pieslēgties / Reģistrēties</a>
            </div>
        </div>
        <div v-if="!activeQuestion && !results">
            <input type="text" v-model="name">
            <select v-model="activeQuizId">
                <option v-for="quiz in allQuizzes" :value="quiz.id">{{ quiz.name }}</option>
            </select>
            <button @click="onStart">Start</button>
        </div>
        <div v-else-if="activeQuestion">
            <div>Hello, {{name}}!</div>
            <QuestionItem/>
        </div>

        <Results/>
    </div>
</template>
<script>
    import {mapActions} from 'vuex';
    import Quiz from '../models/model.quiz.js';
    import QuestionItem from './QuestionItem';
    import Results from './Results';
    // import Logo from './Logo';
    import Logo from '../assets/logo.svg';

    // import TextInput from

    export default {
        name: 'Quiz',
        components: {QuestionItem, Results, Logo},
        computed: {
            name: {
                get() {
                    return this.$store.state.name;
                },
                set(newName) {
                    this.setName(newName);
                }
            },
            activeQuizId: {
                get() {
                    return this.$store.state.activeQuizId;
                },
                set(newValue) {
                    // this.$store.commit('setActiveValueId', newValue);
                    this.setActiveQuizId(newValue);
                }
            },
            allQuizzes: {
                get() {
                    return this.$store.state.allQuizzes;

                }
            },
            activeQuestion: {
                get() {
                    return this.$store.state.activeQuestion;
                }
            },
            results: {
                get() {
                    return this.$store.state.result;
                }
            }
        },
        methods: Object.assign({}, mapActions([
            'setAllQuizzes',
            'setActiveQuizId',
            'setName',
            'start',
        ]), {
            onStart() {
                if (!this.name) {
                    console.log('no name');
                    return;
                }
                if (!this.activeQuizId) {
                    console.log('no active id');
                    return;
                }

                this.start();
            }
        }),
        created() {
            this.setAllQuizzes();
        }
    }
</script>