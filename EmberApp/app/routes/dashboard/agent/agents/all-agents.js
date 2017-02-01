import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {
        return this.get('store').query('agent', {
            page: 1,
            offset: 8,
            sidx: 'id',
            sord: 'asc'
        });

    },
    setupController : function(controller, model){
        this._super(...arguments);
        controller.set('page', 1);
        controller.set('maxPages', model.meta.pages);
        controller.set('totalItems', model.meta.totalItems);
        this.get('store').findAll('group', { reload: true }).then(function (groups) {
            let array = [];
            groups.forEach(function (item) {
                array.push({
                    name: item.get('name'),
                    value: item.id,
                });
            });

            controller.set('groupsModel', array);
        });
    }
});
