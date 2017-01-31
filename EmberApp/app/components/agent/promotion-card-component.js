import Ember from 'ember';
import RSVP from 'rsvp';
import { task, timeout } from 'ember-concurrency';
const {ApiCode, Translator, Routing} = window;


export default Ember.Component.extend({
    authorizedAjax       : Ember.inject.service('authorized-ajax'),
    isModalOpen          : false,
    isSuperiorModalOpen  : false,
    currentAgent         : null,
    currentSuperior      : null,
    currentSuperiorRole  : null,
    newSuperiorId        : null,
    demoteButtonDisabled : true,
    promoteButtonDisabled: true,
    actions:{
        promote(agent){
            this.set('currentAgent', agent);
            if(agent.role_name === this.get('role_codes').role_referee){
                this.set('isModalOpen', true);
                this.set('currentSuperior', null);
            } else {
                let data = {
                    agent_id : this.get('currentAgent').agent_id,
                    action   : "promote"
                };
                this.sendRequest(data, null, this);
            }
        },
        doPromotion(){
            let data = {
                agent_id : this.get('currentAgent').agent_id,
                superior : parseInt(this.get('currentSuperior.id')),
                action   : "promote"
            };

            this.sendRequest(data, null, this);
        },
        demote(agent){
            this.set('currentAgent', agent);
            if(agent.role_name === this.get('role_codes').role_active_agent){
                this.set('isSuperiorModalOpen', true);
                this.set('currentSuperiorRole', null);
            } else {
                let data = {
                    agent_id : this.get('currentAgent').agent_id,
                    action   : "demote"
                };
                this.sendRequest(data, null, this);
            }
        },
        doDemotion(){
            let data = {
                agent_id      : this.get('currentAgent').agent_id,
                newSuperiorId : this.get('newSuperiorId'),
                action        : "demote"
            };
            this.sendRequest(data, null, this);
        },

        agentSelected(agent){
            this.set('promoteButtonDisabled', agent == null);
            this.set('currentSuperior', agent);
        },

        newSuperiorRoleSelected(role){
            this.set('currentSuperiorRole', role);
            let data = {
                id: this.get('currentAgent').agent_id,
                type: role.get('name')
            };

            let route = Routing.generate('check-new-superior-type');
            return new RSVP.Promise(() => {
                this.get('authorizedAjax').sendAuthorizedRequest(data, 'POST', route,
                    function (response) {
                        if(response.data != null){
                            this.set('demoteButtonDisabled', false);
                            this.set('newSuperiorId', response.data);
                        } else {
                            this.toast.error(Translator.trans('models.agent.no.superior.role.exists'));
                            this.set('demoteButtonDisabled', true);
                        }
                    }.bind(this));
            });
        }
    },
    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchQuery')(page, text, perPage);
    }),
    resetFields(){
        this.set('currentAgent', null);
        this.set('currentSuperior', null);
        this.set('currentSuperiorRole', null);
        this.set('newSuperiorId', null);
    },
    sendRequest(data, route, ctx){
        if(!route) {
            route = Routing.generate('promote-agent');
        }

        return new RSVP.Promise(() => {
            this.get('authorizedAjax').sendAuthorizedRequest(data, 'POST', route,
                function (response) {
                    if(ctx){
                        if(response.data.id){
                            if(data.action === 'promote'){
                                ctx.get('deletePromotion')(data.agent_id);

                            } else {
                                ctx.get('deleteDemotion')(data.agent_id);
                            }
                            ctx.toast.success(Translator.trans('models.agent.updated.profile'));
                            ctx.get('transitionToRoute')(data.agent_id);
                        } else {
                            response.errors.forEach((error)=>{
                                switch (parseInt(error.status)) {
                                    case ApiCode.AGENT_SYNC_ERROR:
                                        this.toast.error(Translator.trans('models.agent.sync.error'));
                                        break;
                                    case ApiCode.ERROR_MESSAGE:
                                        this.toast.error(error.message);
                                        break;
                                    default:
                                        return;
                                }
                            });
                        }
                    }
                }.bind(this));
        });
    }
});
