import Ember from 'ember';
const {computed} = Ember;

export default Ember.Component.extend({
    status: [{
        name: 'NEW'
    },{
        name: 'ACTIVE'
    },{
        name: 'SOLVED'
    }
    ],

    selectedStatus: null,
    currentStatus: computed('ticketStatus', function() {
        return this.get('status').findBy('name', this.get('ticketStatus'));
    }),

    actions: {
        statusChanged: function (status) {
            this.set('selectedStatus', status);
            this.get('onStatusSelected')(status ? status.name : status);
        }
    }
});
