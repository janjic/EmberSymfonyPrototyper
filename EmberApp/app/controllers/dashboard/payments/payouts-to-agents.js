import Ember from 'ember';

export default Ember.Controller.extend({
    store: Ember.inject.service(),
    groupsModel: [],
    page: 1,
    offset: 8,
    isModalOpen:false,

    actions: {
        filterModel (searchArray, page) {
            return this.get('store').query('payment-info', {
                page: page,
                offset: this.get('offset'),
                sidx: 'id',
                sord: 'desc',
                filters: JSON.stringify(searchArray)
            });
        },

        openModal() {
            this.set('isModalOpen', true);
        }
    }
});