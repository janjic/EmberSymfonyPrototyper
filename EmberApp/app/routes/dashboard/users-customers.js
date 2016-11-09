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
    }
});
