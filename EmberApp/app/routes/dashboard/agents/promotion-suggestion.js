import Ember from 'ember';
import RSVP from 'rsvp';

export default Ember.Route.extend({
    session: Ember.inject.service('session'),
    model() {
        // return this.get('store').query('agent-promotion-suggestion', {
        //     page: 1,
        //     offset: 8,
        //     sidx: 'id',
        //     sord: 'asc'
        // });
        /** set access token to ajax requests sent by orgchart library */
        let accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;

        Ember.$.ajaxSetup({
            beforeSend: (xhr) => {
                accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
                xhr.setRequestHeader('Authorization', accessToken);
            },
            headers: { 'Authorization': accessToken }
        });

        return Ember.$.ajax({
            type: "GET",
            // url: Routing.generate('agent-promotion-suggestion'),
            url: '/app_dev.php/api/agent-promotion-suggestions',
        }).then(function (response) {
            return RSVP.hash({
                promotions: response.promotions,
                downgrades: response.downgrades,
                role_codes: response.role_codes
            });
        });
    }
});
