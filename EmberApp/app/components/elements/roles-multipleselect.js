import Ember from 'ember';

export default Ember.Component.extend({
    store: Ember.inject.service(),

    roles: [],

    init() {
        this._super(...arguments);
        this.set('roles', this.get('store').findAll('role'));
        if (!this.get('selectedRoles')) {
            this.set('selectedRoles', []);
        }
    },

    actions: {
        selectAction: function () {
            const selectedBandIds = Ember.$(event.target).val() ? Ember.$(event.target).val() : [];
            let retArray = [];
            this.get('roles').forEach(function (item) {
                if (selectedBandIds.indexOf(item.get('id')) > -1) {
                    retArray.push(item);
                }
            });

            this.get('onSelectAction')(retArray);
        }
    }

});