import Ember from 'ember';
import DS from 'ember-data';

var underscore = Ember.String.underscore;

export default DS.JSONAPISerializer.extend({
    keyForAttribute: function(attr) {
        return underscore(attr);
    },

    keyForRelationship: function(rawKey) {
        return underscore(rawKey);
    },
});

// export default DS.RESTSerializer.extend(DS.EmbeddedRecordsMixin, {
//     attrs: {
//         image: {embedded: 'always'},
//         address: {embedded: 'always'}
//     }
// });
