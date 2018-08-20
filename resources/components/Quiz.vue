<template>
    <div>
        <input type="text" v-model="name">
        <select v-model="activeQuizId">
            <option v-for="quiz in allQuizzes" :value="quiz.id">{{ quiz.name }}</option>
        </select>
        <button @click="onStart">Start</button>
    </div>
</template>
<script>
    import {mapActions} from 'vuex';

    export default{
        name: 'Quiz',
        computed: {
            name:{
                get(){
                    return this.$store.state.name;
                },
                set(newName){
                    this.setName(newName);
                }
            },
            activeQuizId: {
                get(){
                    return this.$store.state.activeQuizId;
                },
                set(newValue){
                    // this.$store.commit('setActiveValueId', newValue);
                    console.log(newValue);
                    this.setActiveQuizId(newValue);
                }
            },
            allQuizzes: {
                get(){
                    return this.$store.state.allQuizzes;

                }
            }
        },
        methods: Object.assign({}, mapActions([
            'setAllQuizzes',
            'setActiveQuizId',
            'setName',
            'start',
        ]), {
            onStart(){
                if(!this.name){
                    console.log('no name');
                    return;
                }
                if(!this.activeQuizId){
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