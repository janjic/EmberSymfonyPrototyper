import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
const {Routing} = window;

export default Ember.Component.extend(LoadingStateMixin, {
    store: Ember.inject.service('store'),
    session: Ember.inject.service('session'),

    didInsertElement () {
        this._super(...arguments);
        this.generateChart();
    },

    changeParent (elementId, newParentId, oldParentId) {
        if (newParentId === oldParentId) {
            return;
        }

        this.showLoader();
        var newParentPromise = this.get('store').findRecord('agent', newParentId);
        var agentPromise = this.get('store').findRecord('agent', elementId);

        Ember.RSVP.allSettled([newParentPromise, agentPromise]).then(([npPromise, agPromise]) => {
            let newParent = npPromise.value;
            let agent = agPromise.value;

            agent.set('superior', newParent);
            agent.save().then(() => {
                this.toast.success('Agent saved!');
                this.disableLoader();
            }, () => {
                this.toast.error('Data not saved!');
                this.generateChart();
                this.disableLoader();
            });
        }, () => {
            this.toast.error('Data not saved!');
            this.disableLoader();
            this.generateChart();
        });
    },

    generateChart () {
        /** set access token to ajax requests sent by orgchart library */
        let accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
        $.ajaxSetup({
            beforeSend: (xhr) => {
                accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
                xhr.setRequestHeader('Authorization', accessToken);
            },
            headers: { 'Authorization': accessToken }
        });

        var ajaxURLs = {
            'children': function(nodeData) {
                return Routing.generate('api_agents_orgchart_children', {'id': nodeData.id});
            }
        };

        this.$('#chart-container').html('');
        this.$('#chart-container').orgchart({
            'data' : Routing.generate('api_agents_orgchart'),
            'ajaxURL': ajaxURLs,
            // 'nodeContent': 'email',
            'nodeContent': 'id',
            'draggable': true,
            'depth': 2,
            'toggleSiblingsResp': true,
            'createNode': function($node, data) {
                var secondMenuIcon = $('<i>', {
                    'class': 'fa fa-info-circle second-menu-icon',
                    click: function() {
                        $(this).siblings('.second-menu').toggle();
                    }
                });
                var secondMenu = '<div class="second-menu">ASDDDDDD</div>';
                $node.append(secondMenuIcon);
            }
        }).children('.orgchart').on('nodedropped.orgchart', (event) => {
            this.changeParent(event.draggedNode.attr('id'), event.dropZone.attr('id'), event.dragZone.attr('id'));
        });
    }

});
