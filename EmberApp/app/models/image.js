import DS from 'ember-data';

const { attr, Model } = DS;

export default DS.Model.extend({
    name:           attr('string'),
    webPath:        attr('string'),
    base64_content: attr('string'),
    user:           DS.belongsTo('user', {inverse: 'image' })
});
