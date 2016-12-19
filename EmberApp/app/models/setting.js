import DS from 'ember-data';

const { attr, hasMany, Model } = DS;

export default Model.extend({
    language:           attr('string'),
    confirmationMail:   attr('string'),
    payPal:             attr('string'),
    facebookLink:       attr('string'),
    easycall:           attr('string'),
    twitterLink:        attr('string'),
    gPlusLink:          attr('string'),
    commissions:        hasMany('commission', {inverse: 'settings'}),
    bonuses:            hasMany('bonus', {inverse: 'settings'})
});
