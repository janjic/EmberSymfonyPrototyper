import Ember from 'ember';

export default Ember.Component.extend({
    firstBtnClasses: "button dark icon-btn",
    secondBtnClasses: "button dark icon-btn",
    inputClasses:  Ember.computed('focusable', function () {
        if (!this.get('focusable')) {
            return 'form-control input-lg search-input';
        }
        return 'form-control input-lg search-input clicked';

    }),
    limitAll: true,

    actions: {
        addClickedClass() {
            this.set('focusable', true);
        },
        removeClickedClass (){
            this.set('focusable', false);
        },
        setSearch (input) {
            if (Object.is(parseInt(input), 1)) {
                this.set('firstBtnClasses', "button dark icon-btn green");
                this.set('secondBtnClasses', "button dark icon-btn");
            } else {
                this.set('firstBtnClasses', "button dark icon-btn");
                this.set('secondBtnClasses', "button dark icon-btn green");
            }
            this.toggleProperty('limitAll');
        }
    }
});
