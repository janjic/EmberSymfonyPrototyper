import Ember from 'ember';
import DS from 'ember-data';

var underscore = Ember.String.underscore;

export default DS.JSONAPISerializer.extend({
    // keyForAttribute: function(attr) {
    //     return attr;
    // },
    //
    // keyForRelationship: function(rawKey) {
    //     return rawKey;
    // }
});
