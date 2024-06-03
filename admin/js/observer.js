export class Observer {
    #listeners;

    constructor(listeners) {
        this.#listeners = listeners;
    }

    notify(event) {
        for (let listener of this.#listeners) {
            listener.handle(event);
        }
    }
};