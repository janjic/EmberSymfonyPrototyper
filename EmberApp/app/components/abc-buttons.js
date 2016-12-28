import Ember from 'ember';

export default Ember.Component.extend({

    letters: Ember.computed(function() {
        return Array.apply(null, {length: 26}).map(function (x,i) {
            return String.fromCharCode(97 + i).toUpperCase();
        });
    })

});