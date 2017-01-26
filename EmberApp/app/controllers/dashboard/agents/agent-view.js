import Ember from 'ember';
import AgentControllerActionsMixin from './../../../mixins/agent-controller-actions';

export default Ember.Controller.extend(AgentControllerActionsMixin, {
    page: 1,
    offset: 4,
    isSubAgentsLoading: true,
    subAgents: [],

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
        getAllSubAgents(){
            this.store.query('agent', {
                page: 1,
                offset: 4,
                sidx: 'id',
                sord: 'asc',
                promoCode: this.get('promoCode')
            }).then((response)=>{
                this.set('isSubAgentsLoading', false);
                this.set('subAgents', response);
                this.set('maxPages', response.meta.pages);
                this.set('totalItems', response.meta.totalItems);
                this.set('page', 1);
            });
        }
    }
});
