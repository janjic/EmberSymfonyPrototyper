import Ember from 'ember';
const { inject: { service }, Component} = Ember;

export default Ember.Controller.extend( {
    currentUser:            service('current-user')
});
