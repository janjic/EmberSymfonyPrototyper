import DS from 'ember-data';

const { attr, hasMany, belongsTo, Model } = DS;

export default Model.extend({
    language:           attr('string'),
    confirmationMail:   attr('string'),
    payPal:             attr('string'),
    facebookLink:       attr('string'),
    easycall:           attr('string'),
    twitterLink:        attr('string'),
    gPlusLink:          attr('string'),
    image:              belongsTo('image'),
    commissions:        hasMany('commission', {inverse: 'settings'}, {async: true}),
    bonuses:            hasMany('bonus', {inverse: 'settings'}, {async: true})
});
