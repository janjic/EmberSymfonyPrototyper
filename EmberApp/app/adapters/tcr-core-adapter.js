import Ember from 'ember';
import  ApplicationAdapter from './application';

export default ApplicationAdapter.extend({
    ajaxService: Ember.inject.service('ajax'),
    host: 'https://tcr-media.fsd.rs:105/en',
    namespace: ''
});
