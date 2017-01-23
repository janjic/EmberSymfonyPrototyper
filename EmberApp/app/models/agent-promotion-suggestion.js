import DS from 'ember-data';
const { attr } = DS;

export default DS.Model.extend({
    agentId:             attr('number'),
    image_webPath:       attr('string'),
    full_name:           attr('string'),
    role_name:           attr('string'),
    nationality:         attr('string'),
    email:               attr('string'),
    role_code:           attr('string'),
    active_agents_numb:  attr('string'),
    type:                attr('string')
});
