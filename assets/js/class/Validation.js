export default class Validation {

    constructor(error) {
        this.messages = {};

        if (error.hasOwnProperty('violations')) {
            error.violations.forEach(violation => {
                const k = violation.propertyPath;
                if (!this.messages.hasOwnProperty(k)) {
                    this.messages[k] = [];
                }
                this.messages[k].push(violation.message);
            });
        }
    }

    getInputClass(k) {
        return this.messages.hasOwnProperty(k) ? 'is-invalid' : 'is-valid';
    }

    getMessages(k) {
        return this.messages[k] || [];
    }

}
