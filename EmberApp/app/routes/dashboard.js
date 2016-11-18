import Ember from 'ember';
import AuthenticatedRouteMixin from 'ember-simple-auth/mixins/authenticated-route-mixin';
import Configuration from 'ember-simple-auth/configuration';
const { service } = Ember.inject;
const { Route } = Ember;

export default Route.extend(AuthenticatedRouteMixin, {
});