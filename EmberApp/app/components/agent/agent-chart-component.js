import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
import { task, timeout } from 'ember-concurrency';
const {Routing, Translator} = window;

export default Ember.Component.extend(LoadingStateMixin, {
    store: Ember.inject.service('store'),
    session: Ember.inject.service('session'),
    routing: Ember.inject.service('-routing'),

    isModalOpen: false,
    agentToDelete: null,
    agentToReplaceId: null,

    isDeleteDisabled: Ember.computed('agentToDelete', 'agentToReplaceId', function () {
        return this.get('agentToDelete') === null || this.get('agentToReplaceId') === null;
    }),

    didInsertElement () {
        this._super(...arguments);
        this.generateChart();
    },

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
    }),

    actions: {
        openModal() {
            this.set('isModalOpen', true);
        },

        agentSelected(agent){
            this.set('agentToReplaceId', agent.get('id'));
        },

        closedAction(){
            this.set('agentToDelete', null);
            this.set('agentToReplaceId', null);
        },

        deleteAgent(){
            this.showLoader();
            var agent = this.get('agentToDelete');
            agent.set('newParentForDeleteId', this.get('agentToReplaceId'));

            agent.destroyRecord().then(() => {
                this.set('newParentForDelete', null);
                this.set('agentToReplaceId', null);
                this.set('isModalOpen', false);
                this.generateChart();
                this.toast.success('models.agent.delete');
                this.disableLoader();
            }, (response) => {
                agent.rollbackAttributes();
                this.processErrors(response.errors);
                this.disableLoader();
            });
        },
    },

    deleteAgentOpenModal(agentId) {
        this.get('store').find('agent', agentId).then((agent)=>{
            this.set('agentToDelete', agent);
            this.set('isModalOpen', true);
        });
    },

    suspendAgent(agentId) {
        this.get('store').find('agent', agentId).then((agent)=>{
            agent.set('enabled', !agent.get('enabled'));
            agent.save().then(() => {
                this.toast.success('agent.status.changed');
            }, () => {
                this.toast.error('Data not saved!');
            }).finally(()=>{
                this.disableLoader();
            });
        });
    },

    changeParent (elementId, newParentId, oldParentId) {
        if (newParentId === oldParentId) {
            return;
        }

        this.showLoader();
        let newParentPromise = this.get('store').findRecord('agent', newParentId);
        let agentPromise = this.get('store').findRecord('agent', elementId);

        Ember.RSVP.allSettled([newParentPromise, agentPromise]).then(([npPromise, agPromise]) => {
            let newParent = npPromise.value;
            let agent = agPromise.value;

            agent.set('superior', newParent);
            agent.save({adapterOptions: {
                isGenerologyTree: true
            }
            }).then(() => {
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
            'nodeContent': 'groupName',
            // 'nodeContent': 'id',
            'draggable': true,
            'depth': 2,
            'toggleSiblingsResp': true,
            'createNode': ($node, data) => {
                let secondMenuIcon = Ember.$('<i>', {
                    'class': 'fa fa-info-circle second-menu-icon',
                    click: function() {
                        Ember.$(this).siblings('.second-menu').toggle();
                    }
                });
                // let secondMenu = '<div class="second-menu" hidden><ul><li>Lorem: '+data.id+'</li><li>Lorem: ipsum</li><li>Lorem: ipsum</li></ul></div>';
                let secondMenu =
                    '<div class="second-menu" hidden data-id="'+data.id+'"><div class="flex-view">' +
                    '<div class="img-holder"><img class="avatar" src="'+data.baseImageUrl+'">' +
                    '<a class="button green icon-btn linkToEdit"><i class="fa fa-pencil"></i></a></div>' +
                    '<div class="actions"><a class="button green icon-btn linkToSuspend">'+Translator.trans('agent.change.status')+'</a>' +
                    '<a class="button red icon-btn linkToDelete">Delete</a></div>' +
                    '</div></div>';
                $node.append(secondMenuIcon).append(secondMenu);
            }
        }).children('.orgchart').on('nodedropped.orgchart', (event) => {
            this.changeParent(event.draggedNode.attr('id'), event.dropZone.attr('id'), event.dragZone.attr('id'));
        });

        this.$('#chart-container').dblclick('.node', (event) => {
            let id = this.$(event.target).closest('.node').attr('id');
            if (parseInt(id)) {
                this.get('redirectToEdit')(id);
            }
        });

        /** edit in sidebar */
        this.$('#chart-container').on('click', '.linkToEdit', (event) => {
            let id = this.$(event.target).closest('.second-menu').data('id');
            if (parseInt(id)) {
                this.get('redirectToEdit')(id);
            }
        });

        /** suspend agent */
        this.$('#chart-container').on('click', '.linkToSuspend', (event) => {
            let id = this.$(event.target).closest('.second-menu').data('id');
            if (parseInt(id)) {
                this.suspendAgent(id);
            }
        });

        /** suspend agent */
        this.$('#chart-container').on('click', '.linkToDelete', (event) => {
            let id = this.$(event.target).closest('.second-menu').data('id');
            if (parseInt(id)) {
                this.deleteAgentOpenModal(id);
            }
        });
    }

});
