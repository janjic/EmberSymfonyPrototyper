import Ember from 'ember';

export default Ember.Controller.extend({
    colNames: ['ID', 'First Name', 'Last Name', ' Username', 'Confirmed', 'Country', ''],
    colModels: ['id', 'firstName', 'lastName', 'username', 'enabled'],
    actions: {
        prevPage: function () {
            if (this.get('page') > 1) {
                this.transitionToRoute({
                    queryParams: {
                        page: this.decrementProperty('page'),
                        offset: 10
                    }
                });
            }
        },
        nextPage: function () {
            this.transitionToRoute({
                queryParams: {
                    page: this.incrementProperty('page'),
                    offset: 10
                }
            });
        },
        filterModel: function (colon, value) {
            console.log('Search', colon + ' - ' + value);
        }
    }
});
