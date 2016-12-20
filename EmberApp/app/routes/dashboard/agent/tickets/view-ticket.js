import Ember from 'ember';

export default Ember.Route.extend({
    model: function (params) {
        let ctx = this;
        return this.store.findRecord('ticket', params.id).then((ticket) => {
            console.log(ticket);
            return ticket;
        }, (response) => {
            response.errors.forEach((error)=>{
                if(parseInt(error.status) === 403){
                    ctx.transitionTo('dashboard');
                }
            });
        });
    }
});
