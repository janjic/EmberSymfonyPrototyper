import Ember from 'ember';
import PermissionCheckerMixin from './../../../../mixins/permission-checker';

export default Ember.Controller.extend(PermissionCheckerMixin, {
    actions: {
        search (page, text, perPage) {
            return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
        },

        createFile(hash) {
            return this.get('store').createRecord('file', hash);
        },

        transitionToInbox() {
            if (this.get('currentUser.user.roles').includes('ROLE_SUPER_ADMIN')) {
                this.transitionToRoute('dashboard.messages.sent');
            } else {
                this.transitionToRoute('dashboard.agent.messages.sent');
            }
        }
    }
});
