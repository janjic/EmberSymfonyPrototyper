import DS from 'ember-data';
import Ember from 'ember';

const {  attr, Model } = DS;

export default Model.extend({
    createdBy:      DS.belongsTo('agent'),
    participants:   DS.hasMany('agent'),
    messages:       DS.hasMany('message'),
    createdAt:      attr('custom-date'),
    subject:        attr('string'),
    changeDeleted:  attr('boolean'),
    isRead:         attr('boolean'),

    otherParticipant: Ember.computed('createdBy', 'participants', function () {
        return this.get('participants').find((item) => {
            return item.id !== this.get('createdBy').get('id');
        });
    }),
});