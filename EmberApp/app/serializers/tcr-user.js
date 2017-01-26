import Ember from 'ember';
import DS from 'ember-data';
import isEnabled from 'ember-data/-private/features';

var underscore = Ember.String.underscore;

export default DS.JSONAPISerializer.extend({

    keyForAttribute: function(attr) {
        return attr;
    },

    keyForRelationship: function(rawKey) {
        return rawKey;
    },
    normalizeQueryResponse (store, primaryModelClass, payload){
        let responseData = {};
        responseData['data']= [];
        responseData['meta'] = {
            page: payload.description.current,
            pages: payload.description.pageCount,
            totalItems: payload.description.totalCount
        };

        payload.items.forEach(function (item) {
            responseData['data'].push({
                type: 'tcr-user',
                id: item.id,
                attributes: {
                    firstName: item.name,
                    lastName: item.surname,
                    username: item.username,
                    country: item.country,
                    email: item.email,
                    enabled: item.enabled,
                    created_at: item.created_at,
                    baseImageUrl: item.baseImageUrl
                },
            });
        });

        return responseData;
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
});