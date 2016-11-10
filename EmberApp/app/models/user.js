import DS from 'ember-data';
import Ember from 'ember';
import Image from './image';
import Address from './address';

const { attr, Model } = DS;

export default Model.extend({
    firstName: attr('string'),
    lastName:  attr('string'),
    image:     DS.belongsTo('image', {inverse: 'user'}),
    baseImageUrl: attr('string'),
    username:  attr('string'),
    password:  attr('string'),
    plainPassword:  attr('string'),
    email:     attr('string'),
    address:   DS.belongsTo('address', {inverse: 'user'}),
    language:  attr('string'),
    birthDate: attr('custom-date'),
    comment:   attr('string'),
    isAdmin:   attr('boolean')
});
