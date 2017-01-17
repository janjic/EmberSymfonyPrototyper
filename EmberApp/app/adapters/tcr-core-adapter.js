import Ember from 'ember';
import DS from 'ember-data';

export default DS.JSONAPIAdapter.extend( {
    ajax: Ember.inject.service(),
    host: 'https://tcr-media.fsd.rs:105/app_dev.php/en',
    namespace: ''
});
