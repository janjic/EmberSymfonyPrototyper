import Ember from 'ember';

export default Ember.Controller.extend({
    colNames: ['ID', 'First Name', 'Last Name', ' Username', 'Confirmed', 'Country', 'Actions'],
    colModels: [
        {value: 'id', compare:'cn'},
        {value: 'firstName', compare:'cn'},
        {value: 'lastName', compare:'cn'},
        {value: 'username', compare:'cn'},
        {value: 'enabled', compare:'eq', compareValues: [{name: 'true', value:'1'},{name: 'false', value:'0'}]},
        {value: 'country', compare:'cn'}],
    actions: {
        filterModel: function (searchArray, page, column, sortType) {
            return this.get('store').query('tcrUser', {
                page: page,
                offset: this.get('offset'),
                sidx: column,
                sord: sortType,
                filters: JSON.stringify(searchArray),
                agentId: this.get('agentId')
            });
        },

        sendInvites(cUser, mailList){
            return this.get('store').createRecord('invitation', {
                agent:          cUser,
                mailList:       mailList
            });
        },
        transitionToRoute(route){
            this.transitionToRoute(route);
        }
    }
});