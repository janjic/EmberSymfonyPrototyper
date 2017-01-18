// import Ember from 'ember';
import DS from 'ember-data';
import isEnabled from 'ember-data/-private/features';

export default DS.JSONAPISerializer.extend({
    keyForAttribute: function(attr) {
        return attr;
    },

    keyForRelationship: function(rawKey) {
        return rawKey;
    },
    //
    // /**
    //  @method serializeBelongsTo
    //  @param {DS.Snapshot} snapshot
    //  @param {Object} json
    //  @param {Object} relationship
    //  */
    // serializeBelongsTo(snapshot, json, relationship) {
    //     let key = relationship.key;
    //
    //     if (this._canSerialize(key)) {
    //         let belongsTo = snapshot.belongsTo(key);
    //         if (belongsTo !== undefined) {
    //
    //             json.relationships = json.relationships || {};
    //
    //             let payloadKey = this._getMappedKey(key, snapshot.type);
    //             if (payloadKey === key) {
    //                 payloadKey = this.keyForRelationship(key, 'belongsTo', 'serialize');
    //             }
    //
    //             let data = null;
    //             if (belongsTo) {
    //                 let payloadType;
    //
    //                 if (isEnabled("ds-payload-type-hooks")) {
    //                     payloadType = this.payloadTypeFromModelName(belongsTo.modelName);
    //                     let deprecatedPayloadTypeLookup = this.payloadKeyFromModelName(belongsTo.modelName);
    //
    //                     if (payloadType !== deprecatedPayloadTypeLookup && this._hasCustomPayloadKeyFromModelName()) {
    //
    //                         payloadType = deprecatedPayloadTypeLookup;
    //                     }
    //                 } else {
    //                     payloadType = this.payloadKeyFromModelName(belongsTo.modelName);
    //                 }
    //
    //                 let belongsToAttrs = belongsTo.attributes();
    //                 let belongsData = {};
    //
    //                 for (let attr in belongsToAttrs) {
    //                     if (belongsToAttrs.hasOwnProperty(attr)) {
    //                         belongsData[attr] = belongsToAttrs[attr];
    //                     }
    //                 }
    //
    //                 data = {
    //                     type: payloadType,
    //                     id: belongsTo.id,
    //                     attributes: belongsData
    //                 };
    //             }
    //             json.relationships[payloadKey] = { data };
    //         }
    //     }
    // },
});
