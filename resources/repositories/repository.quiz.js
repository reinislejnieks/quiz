import Api from '../api.js';
import Quiz from '../models/model.quiz.js';

class QuizRepository{

    constructor(){
        this.quizApi = new Api('ajax'); //  change
    }

    getAllQuizzes(){
        return new Promise(resolve => {
            this.quizApi.get('get-all-quizzes') // change
                .then(response => {
                   // let quizzes = response.map(Quiz.fromArray);
                   let quizzes = response.data.result.map(Quiz.fromArray);
                   resolve(quizzes);
                }).catch(() => alert('some error'));
        });
    }
    start(name, quizId){
        return new Promise(resolve => {
            this.quizApi.post('start', {name, quizId})
                .then(response => {
                    // apstrādā datus
                    // Questions.from
                    resolve();
                })
        })
    }
}

export default new QuizRepository();