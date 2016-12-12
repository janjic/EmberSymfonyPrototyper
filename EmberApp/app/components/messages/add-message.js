import Ember from 'ember';
import { task, timeout } from 'ember-concurrency';

const { inject: { service }} = Ember;
const { Routing } = window;

export default Ember.Component.extend({
    authorizedAjax: service('authorized-ajax'),
    store: service('store'),

    searchTask: task(function* (term) {

    }),

    actions: {

    }
});