import Ember from 'ember';

export default Ember.Component.extend({
    currentUser: Ember.inject.service('current-user'),

    getOptionForNotification(notifications, option){
        return notifications.includes(option);
    },

    init() {
        this._super(...arguments);
        // this.set('isUserAdmin', this.get('currentUser.isUserAdmin'));
        let notifications = this.get('agent.notifications');
        this.set('optionMessage', this.getOptionForNotification(notifications, 'optionMessage'));
        this.set('optionPayment', this.getOptionForNotification(notifications, 'optionPayment'));
        this.set('optionAgent', this.getOptionForNotification(notifications, 'optionAgent'));
    },

    actions: {
        filterModel (searchArray, page, column, sortType) {
            return this.get('filter')(searchArray, page, column, sortType);
        }
    }
});
