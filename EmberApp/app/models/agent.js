import DS from 'ember-data';
import Ember from 'ember';

const { attr, Model } = DS;

export default Model.extend({
    title:                attr('string'),
    agentId:              attr('string'),
    firstName:            attr('string'),
    lastName:             attr('string'),
    email:                attr('string'),
    emailRepeat:          attr('string'),
    username:             attr('string'),
    privateEmail:         attr('string'),
    password:             attr('string'),
    plainPassword:        attr('string'),
    roles:                attr('array'),
    passwordRepeat:       attr('string'),
    baseImageUrl:         attr('string'),
    socialSecurityNumber: attr('string'),
    nationality:          attr('string'),
    birthDate:            attr('custom-date'),
    bankName:             attr('string'),
    bankAccountNumber:    attr('string'),
    agentBackground:      attr('string'),
    status:               attr('boolean'),
    address:              DS.belongsTo('address', {inverse: 'agent'}),
    group:                DS.belongsTo('group'),
    superior:             DS.belongsTo('agent'),
    image:                DS.belongsTo('image'),

});