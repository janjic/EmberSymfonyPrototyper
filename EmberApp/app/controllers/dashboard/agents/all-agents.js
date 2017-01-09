import Ember from 'ember';
const Translator = window.Translator;
import AgentControllerActionsMixin from './../../../mixins/agent-controller-actions';

export default Ember.Controller.extend(AgentControllerActionsMixin, {
    store: Ember.inject.service(),
    groupsModel: [],
    page: 1,
    offset: 8,
    promoCode: undefined,
    searchArray: undefined,
    colNames: [Translator.trans('ID'), Translator.trans('First Name'), Translator.trans('Last Name'), Translator.trans('Username'), Translator.trans('Agent Type'), Translator.trans('Country'), 'Status', 'Actions'],
    colModels: Ember.computed('groupsModel', function () {
        return [{value: 'id', compare:'cn'},
            {value: 'firstName', compare:'cn'},
            {value: 'lastName', compare:'cn'},
            {value: 'username', compare:'cn'},
            {value: 'group.name', compare:'eq', compareValues: this.groupsModel},
            {value: 'address.country', compare:'cn'},
            {value: 'enabled', compare:'eq', compareValues: [{name: Translator.trans('All'), value: -1}, {name: Translator.trans('Enabled'), value: 1}, {name: Translator.trans('Not Enabled'), value: 0}], formatter: function (value) {
                return value ? Translator.trans('Enabled'): Translator.trans('Not enabled');
            }}
        ];
    }),
    actions: {
        filterModel (searchArray, page, column, sortType) {
            this.set('searchArray', searchArray);
            return this.get('store').query('agent', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: JSON.stringify(searchArray),
                promoCode: this.get('promoCode')
            });
        },

        agentSelected(agent){
            if (agent && agent.get('agentId') ) {
                this.set('promoCode', agent.get('agentId'));
            } else {
                this.set('promoCode', undefined);
            }
            this.store.query('agent', {
                page: 1,
                offset: this.get('offset'),
                sidx: 'id',
                sord: 'asc',
                filters: JSON.stringify(this.get('searchArray')),
                promoCode: this.get('promoCode')
            }).then((model)=>{
                this.set('model', model);
                this.set('maxPages', this.get('model.meta.pages'));
                this.set('totalItems', this.get('model.meta.totalItems'));
            });

        }
    }
});
