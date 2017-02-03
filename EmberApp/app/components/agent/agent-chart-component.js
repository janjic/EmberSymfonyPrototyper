import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
import { task, timeout } from 'ember-concurrency';
import templateToString from '../../helpers/template-to-string';

const {Routing, Translator} = window;
const { getOwner } = Ember;

export default Ember.Component.extend(LoadingStateMixin, {
    store: Ember.inject.service('store'),
    session: Ember.inject.service('session'),
    routing: Ember.inject.service('-routing'),

    isModalOpen: false,
    agentToDelete: null,
    agentToReplaceId: null,

    shouldRemoveChildrenAfterDragAndDrop: false,

    isDeleteDisabled: Ember.computed('agentToDelete', 'agentToReplaceId', function () {
        return this.get('agentToDelete') === null || this.get('agentToReplaceId') === null;
    }),

    agentIdObserver: Ember.observer('agentId', function() {
        if (this.get('agentId') === null) {
            this.set('agentFilter', null);
            this.generateChart();
        }
    }),

    init() {
        this._super(...arguments);
        if (this.get('agentId') === null) {
            this.set('agentFilter', null);
        }
    },

    didInsertElement () {
        this._super(...arguments);
        this.generateChart();
    },

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('store').query('agent', {page:page, rows:perPage, search: text, searchField: 'agent.email'}).then(results => results);
    }),

    setItemCard: task(function * (data, $node) {
        return yield templateToString('template:dynamic-templates/genealogy-tree-item-card', getOwner(this), data, $node);
    }).enqueue(),

    actions: {
        openModal() {
            this.set('isModalOpen', true);
        },

        agentFilterSelected(agent){
            this.set('agentFilter', agent);
            this.set('agentId', agent ? agent.get('id') : null);
            this.generateChart();
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
            this.toast.success('agent.status.change.started');
            agent.save().then(() => {
                this.changeStatusForAgent(agentId, agent.get('enabled'));
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
                this.removeChildrenForNode(newParentId);
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

    getInitialRoute() {
        let filterForId = this.get('agentFilter') ? this.get('agentFilter.id') : null;

        return filterForId ? Routing.generate('api_orgchart_agents', {'parentId': filterForId}) : Routing.generate('api_orgchart_agents');
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
            },
            'parent': function(nodeData) {
                return Routing.generate('api_agents_orgchart_parent', {'parentId': nodeData.parentId});
            },
            'siblings': function(nodeData) {
                return Routing.generate('api_orgchart_agents_siblings', {'id': nodeData.id});
            },
            'families': function(nodeData) {
                return Routing.generate('api_orgchart_agents_families', {'id': nodeData.id});
            }
        };

        this.$('#chart-container').html('');
        this.$('#chart-container').orgchart({
            'data' : this.getInitialRoute(),
            'ajaxURL': ajaxURLs,
            'nodeContent': 'email',
            'draggable': true,
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
        }).children('.orgchart').on('nodedropped.orgchart', (event) => {
            let childrenLength = this.$('.node[id="'+event.dropZone.attr('id')+'"]').closest('table').find('.nodes:first').children().length;
            if (childrenLength === 1) {
                this.set('shouldRemoveChildrenAfterDragAndDrop', true);
            }

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
            if( this.$(event.target) ) {
                let id = this.$(event.target).closest('.second-menu').data('id');
                if (parseInt(id)) {
                    this.get('redirectToEdit')(id);
                }
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

        /** hide opened cards */
        this.$('#chart-container').on('click', '.hideCard', () => {
            this.$('.second-menu:visible').hide();
        });

        let container = this.$("#chart-container");
        container.scrollLeft(this.$("#chart-container table:first").width()/2 - container.width()/2);
    },

    removeChildrenForNode(nodeId) {
        if (this.get('shouldRemoveChildrenAfterDragAndDrop')) {
            this.$('#chart-container .node[id="'+nodeId+'"]').closest('tr').siblings().remove();
            this.$('.node[id="'+nodeId+'"]').find('.bottomEdge').trigger('click');

            /** reset */
            this.set('shouldRemoveChildrenAfterDragAndDrop', false);
        }
    },

    changeStatusForAgent(id, newState) {
        let msg = !newState ? Translator.trans('agent.change.enable') : Translator.trans('agent.change.disable');
        this.$('#chart-container .linkToSuspend[data-agent-id='+id+']').html(msg).toggleClass("red green");
    }

});
