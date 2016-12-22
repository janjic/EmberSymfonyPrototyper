import DS from 'ember-data';
import isEnabled from 'ember-data/-private/features';

export default DS.JSONAPISerializer.extend({
    keyForAttribute: function(attr) {
        return attr;
    },

    keyForRelationship: function(rawKey) {
        return rawKey;
    },

    /**
     @method serializeHasMany
     @param {DS.Snapshot} snapshot
     @param {Object} json
     @param {Object} relationship
     */
    serializeHasMany(snapshot, json, relationship) {
        var key = relationship.key;
        var shouldSerializeHasMany = '_shouldSerializeHasMany';
        if (isEnabled("ds-check-should-serialize-relationships")) {
            shouldSerializeHasMany = 'shouldSerializeHasMany';
        }

        var hasMany = snapshot.hasMany(key);
        if (hasMany !== undefined) {

            json.relationships = json.relationships || {};

            var payloadKey = this._getMappedKey(key, snapshot.type);
            if (payloadKey === key && this.keyForRelationship) {
                payloadKey = this.keyForRelationship(key, 'hasMany', 'serialize');
            }

            let data = new Array(hasMany.length);

            for (let i = 0; i < hasMany.length; i++) {
                let item = hasMany[i];

                let payloadType;

                if (isEnabled("ds-payload-type-hooks")) {
                    payloadType = this.payloadTypeFromModelName(item.modelName);
                    let deprecatedPayloadTypeLookup = this.payloadKeyFromModelName(item.modelName);

                    if (payloadType !== deprecatedPayloadTypeLookup && this._hasCustomPayloadKeyFromModelName()) {
                        deprecate("You used payloadKeyFromModelName to serialize type for belongs-to relationship. Use payloadTypeFromModelName instead.", false, {
                            id: 'ds.json-api-serializer.deprecated-payload-type-for-has-many',
                            until: '3.0.0'
                        });

                        payloadType = deprecatedPayloadTypeLookup;
                    }
                } else {
                    payloadType = this.payloadKeyFromModelName(item.modelName);
                }

                data[i] = {
                    type: payloadType,
                    id: item.id,
                    attributes: item._attributes
                };
            }

            json.relationships[payloadKey] = { data };
        }
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

                            payloadType = deprecatedPayloadTypeLookup;
                        }
                    } else {
                        payloadType = this.payloadKeyFromModelName(belongsTo.modelName);
                    }

                    var belongsToAttrs = belongsTo.attributes();
                    var belongsData = {};

                    for (var attr in belongsToAttrs) {
                        if (belongsToAttrs.hasOwnProperty(attr)) {
                            belongsData[attr] = belongsToAttrs[attr];
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
});