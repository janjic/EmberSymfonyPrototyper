import Ember from 'ember';

export default Ember.Component.extend({
    colNames: [],
    colModel: [],
    route: '',
    didInsertElement: function () {
         console.log(this.get('controller.model.colModel'));
        // setUpjQgrid('grid', this.get('route'), 'All Users', this.get('colNames'), this.get('colModel'), '');

    }
});
