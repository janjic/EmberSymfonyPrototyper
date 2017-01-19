import Ember from 'ember';
const { inject: { service }} = Ember;
const { Routing } = window;

export default Ember.Component.extend({
    authorizedAjax:             service('authorized-ajax'),
    currentUser:                service('current-user'),
    superiorType:               undefined,
    init() {
        this._super(...arguments);
    },

    actions: {
        openModal() {
            this.set('isModalOpen', true);
        },
        closeModal(){
            this.set('isModalOpen', false);
        },
        newSuperiorRoleSelected(newRole){
            this.set('superiorType', newRole.get('name'));
        },
        saveNewSuperiorRole(){
            this.set('isLoading', true);
            let superiorType = this.get('superiorType');
            let agentId      = this.get('changeset.id');

            this.get('authorizedAjax').sendAuthorizedRequest({ id: agentId, type: superiorType }, 'POST', Routing.generate('check-new-superior-type'),
                function (response) {
                    if( response.data ){
                        this.toast.success('Found');
                        this.set('changeset.newSuperiorId', response.data);
                        this.send('closeModal');
                    } else {
                        this.toast.error('Not Found Superior!!');
                    }
                    this.set('isLoading', false);
                }.bind(this), this);
        }
    }
});
