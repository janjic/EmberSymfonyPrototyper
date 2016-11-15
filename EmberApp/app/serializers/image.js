import Ember from 'ember';
import DS from 'ember-data';

var underscore = Ember.String.underscore;

export default DS.JSONAPISerializer.extend({
    keyForAttribute: function(attr) {
        return underscore(attr);
    },

    keyForRelationship: function(rawKey) {
        console.log(rawKey);
        return underscore(rawKey);
    },
    // serializeBelongsTo: function (snapshot, json, relationship) {
    //     console.log(snapshot);
    //     console.log(json);
    //     console.log(relationship);
    // }
});

// export default DS.RESTSerializer.extend(DS.EmbeddedRecordsMixin, {
//     attrs: {
//         image: {embedded: 'always'},
//         address: {embedded: 'always'}
//     }
// });
