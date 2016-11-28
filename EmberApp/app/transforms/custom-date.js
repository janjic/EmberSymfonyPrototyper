import DS from 'ember-data';
export default DS.Transform.extend({
    serialize: function(value) {
        return value;
    },
    deserialize: function(value) {
        console.log(value.date);
        // var date = new Date(value.date);
        // console.log(date);
        // date.setDate(date.getDate()+1);
        return Object.is(value, null)? null:value.date;
    }
});