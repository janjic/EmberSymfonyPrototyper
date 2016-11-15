import Ember from 'ember';
import DS from 'ember-data';
import isEnabled from 'ember-data/-private/features';

var underscore = Ember.String.underscore;

export default DS.JSONAPISerializer.extend({

    keyForAttribute: function(attr) {
        return underscore(attr);
    },

    /**
     @method serializeBelongsTo
     @param {DS.Snapshot} snapshot
     @param {Object} json
     @param {Object} relationship
     */
    serializeBelongsTo(snapshot, json, relationship) {
        var key = relationship.key;

        if (this._canSerialize(key)) {
            var belongsTo = snapshot.belongsTo(key);
            if (belongsTo !== undefined) {

                json.relationships = json.relationships || {};

                var payloadKey = this._getMappedKey(key, snapshot.type);
                if (payloadKey === key) {
                    payloadKey = this.keyForRelationship(key, 'belongsTo', 'serialize');
                }

                var data = null;
                if (belongsTo) {
                    let payloadType;

                    if (isEnabled("ds-payload-type-hooks")) {
                        payloadType = this.payloadTypeFromModelName(belongsTo.modelName);
                        let deprecatedPayloadTypeLookup = this.payloadKeyFromModelName(belongsTo.modelName);

                        if (payloadType !== deprecatedPayloadTypeLookup && this._hasCustomPayloadKeyFromModelName()) {
                            deprecate("You used payloadKeyFromModelName to serialize type for belongs-to relationship. Use payloadTypeFromModelName instead.", false, {
                                id: 'ds.json-api-serializer.deprecated-payload-type-for-belongs-to',
                                until: '3.0.0'
                            });

                            payloadType = deprecatedPayloadTypeLookup;
                        }
                    } else {
                        payloadType = this.payloadKeyFromModelName(belongsTo.modelName);
                    }

                    data = {
                        type: payloadType,
                        id: belongsTo.id,
                        attributes: belongsTo.attributes()
                    };
                }
                json.relationships[payloadKey] = { data };
            }
        }
    },

    keyForRelationship: function(rawKey) {
        console.log(rawKey);
        return underscore(rawKey);
    },
});