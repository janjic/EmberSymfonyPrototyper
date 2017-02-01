import Ember from 'ember';
const {ApiCode} = window;

export function agentHistoryType(params) {
    switch (params[0]){
        case ApiCode.AgentHistoryStatus.SUSPENDED_STATUS :
            return 'agent-history-suspend';
        case ApiCode.AgentHistoryStatus.ENABLED_STATUS:
            return 'agent-history-enable';
        case ApiCode.AgentHistoryStatus.UPGRADE_STATUS:
            return 'agent-history-upgrade';
        case ApiCode.AgentHistoryStatus.DOWNGRADE_STATUS:
            return 'agent-history-downgrade';
    }
}

export default Ember.Helper.helper(agentHistoryType);
