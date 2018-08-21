import $ from 'jquery';
import BenchmarkForm from './benchmark_form';

class App {
    constructor() {
        this.benchmarkForm = new BenchmarkForm();
    }

    init() {
        this.events();
    }

    events() {
        this.benchmarkForm.events();
    }
}

(function() {
    $(document).ready(function() {
        const app = new App();

        app.init();
    })
})();