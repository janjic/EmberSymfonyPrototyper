import Ember from 'ember';

export default Ember.Controller.extend({
    currentUser : Ember.inject.service('current-user'),
    page: 1,
    offset: 10,
    colNames: ['ID', 'Name', 'Surname', 'Order total', 'Date', 'Actions'],
    colModels: Ember.computed('groupsModel', function () {
        return [
            {value: 'id', compare:'cn'},
            {value: 'name', compare:'cn'},
            {value: 'surname', compare:'cn'},
            {value: 'total', compare:'cn'},
            {value: 'created_at', compare:'cn', formatter: function (value) {
                return value.split('T')[0];
            }},
        ];
    }),
    actions: {
        filterModel: function (searchArray, page, column, sortType) {
            /**
             * Always add agent condition
             */
            searchArray.rules.pushObject({
                field: 'user.agent.agent_id',
                op: 'cn',
                data: this.get('currentUser.user.agentId')
            });

            return this.get('store').query('customer-order', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: searchArray,
            });
        }
    }
});
