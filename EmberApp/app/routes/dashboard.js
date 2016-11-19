import Ember from 'ember';
import PermissionCheckerMixin from './../mixins/permission-checker';
const { Route } = Ember;

export default Route.extend(PermissionCheckerMixin, {
});