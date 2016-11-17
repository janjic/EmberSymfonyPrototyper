import Ember from 'ember';
import DS from 'ember-data';
import isEnabled from 'ember-data/-private/features';

var underscore = Ember.String.underscore;
var camelize   = Ember.String.camelize;

export default DS.JSONAPISerializer.extend({

    keyForAttribute: function(attr) {
        return camelize(attr);
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

                    var belongsToAttrs = belongsTo.attributes();
                    var belongsData = {};

                    for (var attr in belongsToAttrs) {
                        if (belongsToAttrs.hasOwnProperty(attr)) {
                            belongsData[underscore(attr)] = belongsToAttrs[attr];
                        }
                    }

                    data = {
                        type: payloadType,
                        id: belongsTo.id,
                        attributes: belongsData
                    };
                }
                json.relationships[payloadKey] = { data };
            }
        }
    },

    keyForRelationship: function(rawKey) {
        return camelize(rawKey);
    },
});