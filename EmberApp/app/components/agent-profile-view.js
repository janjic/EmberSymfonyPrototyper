import Ember from 'ember';

export default Ember.Component.extend({
    currentUser: Ember.inject.service('current-user'),

    getOptionForNotification(option){
        return this.get('currentUser.user.notifications').includes(option);
    },

    init() {
        this._super(...arguments);
        // this.set('isUserAdmin', this.get('currentUser.isUserAdmin'));
        this.set('optionMessage', this.getOptionForNotification('optionMessage'));
        this.set('optionPayment', this.getOptionForNotification('optionPayment'));
        this.set('optionAgent', this.getOptionForNotification('optionAgent'));
    },

    actions: {
        filterModel (searchArray, page, column, sortType) {
            return this.get('filter')(searchArray, page, column, sortType);
        }
    }
});
