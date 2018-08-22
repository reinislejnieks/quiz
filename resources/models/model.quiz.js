export default class Quizz {
    constructor() {
        /**
         * @type {?number}
         */
        this.id = null;

        /**
         * @type {?string}
         */
        this.name = '';
    }

    /**
     * @param {{}} rawData
     * @return {Quizz}
     */
    static fromArray(rawData) {
        let quizz = new Quizz();
        quizz.id = rawData.id;
        quizz.name = rawData.name;

        return quizz;
    }

    /**
     * @return {{}}
     */
    toArray() {
        return {
            id: this.id,
            name: this.name,
        }
    }
}