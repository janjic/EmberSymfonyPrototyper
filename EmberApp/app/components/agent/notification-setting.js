import Ember from 'ember';

export default Ember.Component.extend({
    optionMessage:      false,
    optionPayment:      false,
    optionAgent:        false,

    init() {
        this._super(...arguments);
        this._setUpDefault();
    },

    actions:{
        statusChanged(option, status){
            this.set(option, status);
            if ( status ) {
                this.get('notifications').push(option);
            } else {
                let index = this.get('notifications').indexOf(option);
                if (index > -1) {
                    this.get('notifications').splice(index, 1);
                }
            }
            console.log(this.get('notifications'));
        }
    },

    getOptionForNotification(option){
        return this.get('notifications').includes(option);
    },

    _setUpDefault(){
        this.set('optionMessage', this.getOptionForNotification('optionMessage'));
        this.set('optionPayment', this.getOptionForNotification('optionPayment'));
        this.set('optionAgent', this.getOptionForNotification('optionAgent'));
    }
});
