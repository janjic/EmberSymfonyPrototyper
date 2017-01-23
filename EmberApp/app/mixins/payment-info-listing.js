import Ember from 'ember';

export default Ember.Mixin.create({
    offset: 8,

    actions: {
        filterModel (searchArray, page) {
            return this.get('store').query('payment-info', {
                page: page,
                offset: this.get('offset'),
                sidx: 'id',
                sord: 'desc',
                filters: JSON.stringify(searchArray),
                paymentState: this.get('paymentState')
            });
        },

        searchAgents(page, perPage, text) {
            return this.get('store').query('agent', {
                page:page,
                rows:perPage,
                search: text,
                searchField: 'agent.email'}
            ).then(results => results);
        },

        goToRoute(route) {
            this.transitionToRoute(route);
        }
    }
});
