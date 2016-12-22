// import Ember from 'ember';
import DS from 'ember-data';
import isEnabled from 'ember-data/-private/features';

export default DS.JSONAPISerializer.extend({
    keyForAttribute: function(attr) {
        return attr;
    },

    keyForRelationship: function(rawKey) {
        return rawKey;
    }
});
