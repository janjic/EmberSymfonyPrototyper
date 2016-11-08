import Ember from 'ember';

export default Ember.Route.extend({
    page: 1,
    offset: 10,
    queryParams: {
        page: {
            refreshModel: true
        }
    },
    model: function (params) {
        var page = params.page ? params.page : this.get('page');
        return this.store.query('user', {
            page: page,
            offset: this.get('offset')
        });
    },
    actions: {
        prevPage: function () {
            if (this.get('page') > 1) {
                this.transitionTo({
                    queryParams: {
                        page: this.decrementProperty('page'),
                        offset: 10
                    }
                });
            }
        },
        nextPage: function () {
            this.transitionTo({
                queryParams: {
                    page: this.incrementProperty('page'),
                    offset: 10
                }
            });
        }
    }
});
