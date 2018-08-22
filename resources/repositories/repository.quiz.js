import Api from '../api.js';
import Quiz from '../models/model.quiz.js';
import Question from '../models/model.question.js';

class QuizRepository{

    constructor(){
        // this.quizApi = new Api('/quiz.test/getQuizzesAjax'); //  change
        this.quizApi = new Api('ajax'); //  change
    }

    getAllQuizzes(){
        return new Promise(resolve => {
            // this.quizApi.get('getQuizzes')
            this.quizApi.get('getAllQuizzes') // change
                .then(response => {
                   // let quizzes = response.map(Quiz.fromArray);
                   let quizzes = response.data.result.map(Quiz.fromArray);
                   resolve(quizzes);
                }).catch(() => console.log('some error'));
        });
    }

    start(name, quizId) {
        return new Promise(resolve => {
            this.quizApi.post('start', {name, quizId})
                .then(response => {
                    let question = Question.fromArray(response.data.result);

                    resolve(question)
                })
                .catch(() => console.log('Oh, noooo!'));
        })
    }

    answer( answerId, quizId){
        return new Promise(resolve => {
            this.quizApi.post('answer', {answerId, quizId})
                .then(response => {
                    resolve(
                        (typeof response.data.result === 'string') ?
                            response.data.result :
                            Question.fromArray(response.data.result));

                })
                .catch(() => {
                    console.log('oh, wtf???');
                    debugger;
                })
        })
    }
    // answer(answerId){
    //
    // }
}

export default new QuizRepository();