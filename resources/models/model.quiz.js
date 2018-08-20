export default class Quizz {
    constructor(){
        this.id = null;
        this.name = '';
    }

    static fromArray(rawData){
        let quiz = new Quizz();
        quiz.id = rawData.id;
        quiz.name = rawData.name;

        return quiz;
    }
}