import DS from 'ember-data';
import Ember from 'ember';

const {  attr, Model } = DS;

export default Model.extend({
    createdBy:      DS.belongsTo('agent'),
    participants:   DS.hasMany('agent'),
    messages:       DS.hasMany('message'),
    createdAt:      attr('custom-date'),
    subject:        attr('string'),


    otherParticipant: Ember.computed('createdBy', 'participants', function () {
        let parts = this.get('participants').filter((item) => {
            return item.id !== this.get('createdBy').get('id');
        });

        console.log(parts);

        return parts;
    })
});