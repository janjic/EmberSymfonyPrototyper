import Ember from 'ember';
import AgentControllerActionsMixin from './../../../mixins/agent-controller-actions';

export default Ember.Controller.extend(AgentControllerActionsMixin, {
    page: 1,
    offset: 4,

    actions: {
        filterModel (searchArray, page, column, sortType) {
            return this.get('store').query('agent', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: JSON.stringify(searchArray),
                promoCode: this.get('promoCode')
            });
        },
    }
});
