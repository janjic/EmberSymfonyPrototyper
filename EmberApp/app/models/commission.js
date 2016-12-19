import DS from 'ember-data';

const { attr, belongsTo, Model } = DS;

export default Model.extend({
    settings:       belongsTo('setting', {inverse: 'commissions'}),
    group:          belongsTo('group'),
    setupFee:       attr('number'),
    packages:       attr('number'),
    connect:        attr('number'),
    stream:         attr('number')
});
