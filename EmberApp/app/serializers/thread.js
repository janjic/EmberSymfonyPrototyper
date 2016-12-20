import Ember from 'ember';
import DS from 'ember-data';
const { String:{camelize} } = Ember;

export default DS.JSONAPISerializer.extend({
    keyForAttribute: function(attr) {
        return camelize(attr);
    },

    keyForRelationship: function(rawKey) {
        return camelize(rawKey);
    },
});

