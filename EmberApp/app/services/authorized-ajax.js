import Ember from 'ember';
import AjaxRequestMixin from 'ember-ajax/mixins/ajax-request';

export default Ember.Service.extend(AjaxRequestMixin, {
    session: Ember.inject.service(),

    sendAuthorizedRequest (data, type, url, callBack) {
        return this.get('session').authorize('authorizer:application', (headerName, headerValue) => {
            const headers = {};
            headers[headerName] = headerValue;
            this.set('headers', headers);
            let options = {
                method: type,
                data: data,
            };
            this.request(url, options).then(response => {
                callBack(response);
            });
        });
    }
});