import DS from 'ember-data';
import Ember from 'ember';

export default DS.Transform.extend({

  /**
   *
   * @param serialized
   * @returns {Array}
   */
  deserialize(serialized) {
    return Object.is(Ember.typeOf(serialized), "array") ? serialized : [];
  },
  /**
   *
   * @param deserialized
   * @returns {*}
   */
  serialize(deserialized) {
      var type = Ember.typeOf(deserialized);
      if (Object.is(type, 'array')) {
        return deserialized;
      } else if (Object.is(type, 'string')) {
        return deserialized.split(',').map(function(item) {
          return item.trim();
        });
      } else {
          return [];
      }
  }
});
