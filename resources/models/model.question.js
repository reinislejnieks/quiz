import Answer from '../models/model.answer.js';
export default class Question{
    constructor(){

        /**
         *
         * @type {number}
         */
        this.id = null;

        /**
         *
         * @type {string}
         */
        this.question = '';

        /**
         *
         * @type {Array<Answer>}
         */
        this.answer = [];
    }

    static fromArray(rawData){
        let question = new Question();
        question.id = rawData.id;
        question.question = rawData.question;
        question.answers = rawData.answers.map(Answer.fromArray);

        return question;
    }


}