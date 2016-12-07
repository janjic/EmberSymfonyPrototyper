import Ember from 'ember';
import LoadingStateMixin from '../../mixins/loading-state';
const {Routing} = window;

export default Ember.Component.extend(LoadingStateMixin, {
    store: Ember.inject.service('store'),

    changeParent (elementId, newParentId, oldParentId) {
        if (newParentId === oldParentId) {
            return;
        }

        this.showLoader();
        var newParentPromise = this.get('store').findRecord('agent', newParentId);
        var agentPromise = this.get('store').findRecord('agent', elementId);

        Ember.RSVP.allSettled([newParentPromise, agentPromise]).then(([npPromise, agPromise]) => {
            let newParent = npPromise.value;
            var agent = agPromise.value;

            agent.set('superior', newParent);
            agent.save().then(() => {
                this.toast.success('Agent saved!');
                this.disableLoader();
            }, () => {
                this.toast.error('Data not saved!');
                this.disableLoader();
            });
        }, function() {
            this.toast.error('Data not saved!');
            this.disableLoader();
        });
    },


    didInsertElement () {
        this._super(...arguments);
        let _this = this;
        var ajaxURLs = {
            'children': function(nodeData) {
                return Routing.generate('api_agents_orgchart_children', {'id': nodeData.id});
            }
        };

        this.$('#chart-container').orgchart({
            'data' : Routing.generate('api_agents_orgchart'),
            'ajaxURL': ajaxURLs,
            // 'nodeContent': 'email',
            'nodeContent': 'id',
            'draggable': true,
            'depth': 2,
            'dropCriteria': function($draggedNode, $dragZone, $dropZone) {
                // if($draggedNode.find('.content').text().indexOf('manager') > -1 && $dropZone.find('.content').text().indexOf('engineer') > -1) {
                //     return false;
                // }
                return true;
            }
        }).children('.orgchart').on('nodedropped.orgchart', function(event) {
            _this.changeParent(event.draggedNode.attr('id'), event.dropZone.attr('id'), event.dragZone.attr('id'));
        });
    }
});
