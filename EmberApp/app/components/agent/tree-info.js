import Ember from 'ember';
const { inject: { service }} = Ember;
const {Routing} = window;

export default Ember.Component.extend({
    authorizedAjax: service('authorized-ajax'),
    info: null,
    didInsertElement() {
        this._super(...arguments);
        this.set('isLoaded', false);
        if (this.get('agent.id')) {
            this.get('authorizedAjax').sendAuthorizedRequest(null, 'GET', Routing.generate('agent-info', { id: this.get('agent.id') }),
                function (response) {
                    this.set('info', response.data);
                }.bind(this), this);

            this.set('isLoaded', true);
        } else {
            this.set('isLoaded', true);
        }

    }
});
