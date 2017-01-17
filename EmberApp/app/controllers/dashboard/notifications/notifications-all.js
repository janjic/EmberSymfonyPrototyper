import Ember from 'ember';
const { inject: { service }} = Ember;

export default Ember.Controller.extend( {
    currentUser:            service('current-user'),

    init(){
        this._super(...arguments);
        this.store.query('tcr-user', {
            page: 1,
            offset: 9,
            sidx: 'id',
            sord: 'asc'
        }).then((users)=>{
            this.set('allUsers', users);
        });
    }
});
