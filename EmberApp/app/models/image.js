import DS from 'ember-data';

const { attr } = DS;

export default DS.Model.extend({
    name:           attr('string'),
    webPath:        attr('string'),
    filePath:       attr('string'),
    base64Content:  attr('string'),
    agent:          DS.belongsTo('agent', {inverse: 'image' })
});
