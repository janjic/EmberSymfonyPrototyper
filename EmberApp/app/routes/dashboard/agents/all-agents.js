import Ember from 'ember';

export default Ember.Route.extend({
    model: function () {

        return this.get('store').query('agent', {
            page: 1,
            offset: 10,
            sidx: 'id',
            sord: 'asc'
        });

    },
    setupController : function(controller, model){
        this._super(...arguments);
        this.get('store').findAll('group', { reload: true }).then(function (groups) {
            // console.log(groups.getEach('name'));
            let array = [];
            groups.forEach(function (item) {
                array.push({
                    name: item.get('name'),
                    value: item.id,
                });
            });

            controller.set('groupsModel', array);
        });
        // controller.set('groups', model.groups);

    }
});
