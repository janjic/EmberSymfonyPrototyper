import DS from 'ember-data';
import Ember from 'ember';

const {  attr, Model } = DS;

export default Model.extend({
    createdBy:      DS.belongsTo('agent'),
    participants:   DS.hasMany('agent'),
    messages:       DS.hasMany('message'),
    createdAt:      attr('custom-date'),
    subject:        attr('string'),
    toBeDeleted:    attr('boolean'),

    otherParticipant: Ember.computed('createdBy', 'participants', function () {
        return this.get('participants').find((item) => {
            return item.id !== this.get('createdBy').get('id');
        });
    }),

    messagesInverseOrder: Ember.computed('messages', function () {
        return this.get('messages').toArray().reverse();
    }),

    firstMessage: Ember.computed('messagesInverseOrder', function () {
        return this.get('messagesInverseOrder').get('firstObject');
    })
});