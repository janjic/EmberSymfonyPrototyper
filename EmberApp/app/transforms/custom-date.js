import DS from 'ember-data';
export default DS.Transform.extend({
    serialize: function(value) {
        return value;
    },
    deserialize: function(value) {
        console.log(value.date);
        return Object.is(value, null)? null:value.date;
    }
});