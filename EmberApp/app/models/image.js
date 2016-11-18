import DS from 'ember-data';

const { attr } = DS;

export default DS.Model.extend({
    name:           attr('string'),
    webPath:        attr('string'),
    filePath:       attr('string'),
    base64_content: attr('string'),
    user:           DS.belongsTo('user', {inverse: 'image' }),
    agent:          DS.belongsTo('agent', {inverse: 'image' })
});
