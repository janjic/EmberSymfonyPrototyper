import DS from 'ember-data';

export default DS.RESTSerializer.extend(DS.EmbeddedRecordsMixin, {
    attrs: {
        image: {embedded: 'always'},
        address: {embedded: 'always'}
    }
});
