import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
const {Routing} = window;

export default Ember.Component.extend(LoadingStateMixin, {
    session: Ember.inject.service('session'),
    routing: Ember.inject.service('-routing'),

    didInsertElement () {
        this._super(...arguments);
        this.generateChart();
    },

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
            'data' : Routing.generate('api_orgchart_agents'),
            'ajaxURL': ajaxURLs,
            'nodeContent': 'email',
            'depth': 2,
            'toggleSiblingsResp': true,
            'createNode': ($node, data) => {
                let secondMenuIcon = Ember.$('<i>', {
                    'class': 'fa fa-info-circle second-menu-icon',
                    hover: function() {
                        Ember.$(this).siblings('.second-menu').toggle();
                    }
                });
                let secondMenu =
                    '<div class="second-menu" hidden data-id="'+data.id+'">' +
                    '<img class="avatar img-circle" src="'+(
                        data.baseImageUrl ? data.baseImageUrl : '../assets/images/user-avatar.png'
                    )+'">' +
                    '</div>';
                $node.append(secondMenuIcon).append(secondMenu);
            }
        });
    }

});
