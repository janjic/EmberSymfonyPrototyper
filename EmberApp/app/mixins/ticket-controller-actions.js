import Ember from 'ember';

export default Ember.Mixin.create({
    actions: {
        createNewThread()
        {
            return this.get('store').createRecord('thread');
        },
        createNewMessage(hash)
        {
            return this.get('store').createRecord('message', hash);
        }
    }
});
