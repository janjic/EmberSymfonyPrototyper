import DS from 'ember-data';

const { attr, Model } = DS;

export default Model.extend({
    firstName:     attr('string'),
    lastName:      attr('string'),
    image:         DS.belongsTo('image'),
    baseImageUrl:  attr('string'),
    username:      attr('string'),
    password:      attr('string'),
    repeatPassword:attr('string'),
    plainPassword: attr('string'),
    email:         attr('string'),
    repeatEmail:   attr('string'),
    zip:           attr('string'),
    address:       attr('string'),
    language:      attr('string'),
    birthDate:     attr('custom-date'),
    comment:       attr('string'),
    country:       attr('string'),
    company:       attr('string'),
    isAdmin:       attr('boolean'),
    enabled:       attr('boolean'),
    phoneNumber:   attr('string'),
    title:         attr('string'),
    agent:         DS.belongsTo('agent'),
});
