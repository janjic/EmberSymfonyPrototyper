import Ember from 'ember';
import PermissionCheckerMixin from './../mixins/permission-checker';
const { Route } = Ember;

export default Route.extend(PermissionCheckerMixin, {
    model(){
        return this.store.find('setting', 1);
    },
    setupController(controller) {
        controller.set('user', this.get('currentUser.user'));
        this._super(...arguments);
    }
});