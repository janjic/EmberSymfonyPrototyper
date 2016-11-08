import Ember from 'ember';
const { inject: { service }, Component } = Ember;

export default Component.extend({
    currentUser: service('current-user'),
});
