import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
import templateToString from '../../helpers/template-to-string';
import { task, timeout } from 'ember-concurrency';
const { getOwner } = Ember;

const {Routing} = window;

export default Ember.Component.extend(LoadingStateMixin, {
    session: Ember.inject.service('session'),
    routing: Ember.inject.service('-routing'),
    currentUser: Ember.inject.service('current-user'),

    didInsertElement () {
        this._super(...arguments);
        this.generateChart();
    },

    setItemCard: task(function * (data, $node) {
        return yield templateToString('template:dynamic-templates/genealogy-tree-item-card-agent', getOwner(this), data, $node);
    }).enqueue(),

    generateChart () {
        /** set access token to ajax requests sent by orgchart library */
        let accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
        Ember.$.ajaxSetup({
            beforeSend: (xhr) => {
                accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
                xhr.setRequestHeader('Authorization', accessToken);
            },
            headers: { 'Authorization': accessToken }
        });

        let ajaxURLs = {
            'children': function(nodeData) {
                return Routing.generate('api_orgchart_agents', {'parentId': nodeData.id});
            }
        };

        this.$('#chart-container').html('');
        this.$('#chart-container').orgchart({
            'data' : Routing.generate('api_orgchart_agents', {'parentId': this.get('currentUser.user.id')}),
            'ajaxURL': ajaxURLs,
            'nodeContent': 'email',
            'depth': 2,
            'toggleSiblingsResp': true,
            'createNode': ($node, data) => {
                let secondMenuIcon = Ember.$('<i>', {
                    'class': 'fa fa-info-circle second-menu-icon',
                    click: function() {
                        Ember.$('.second-menu:visible').hide();
                        Ember.$(this).siblings('.second-menu').toggle();
                    }
                });
                $node.append(secondMenuIcon);

                this.get('setItemCard').perform(data, $node);
            }
        });

        /** hide opened cards */
        this.$('#chart-container').on('click', '.hideCard', () => {
            this.$('.second-menu:visible').hide();
        });

        this.$('#chart-container').dblclick('.node', (event) => {
            let id = this.$(event.target).closest('.node').attr('id');
            if (parseInt(id)) {
                this.get('redirectToEdit')(id);
            }
        });
    }

});
