import Ember from 'ember';

export default Ember.Component.extend({
    currentUser: Ember.inject.service('current-user'),

    getOptionForNotification(option){
        return this.get('currentUser.user.notifications').includes(option);
    },

    init() {
        this._super(...arguments);
        this.set('optionMessage', this.getOptionForNotification('optionMessage'));
        this.set('optionPayment', this.getOptionForNotification('optionPayment'));
        this.set('optionAgent', this.getOptionForNotification('optionAgent'));
    },
});
