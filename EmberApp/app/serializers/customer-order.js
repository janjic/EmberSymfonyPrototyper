// import Ember from 'ember';
import DS from 'ember-data';

export default DS.JSONAPISerializer.extend({
    normalizeQueryResponse (store, primaryModelClass, payload, id, requestType){
        let responseData = {};
        responseData['data']= [];
        responseData['meta'] = {
            page: payload.description.current,
            pages: payload.description.pageCount,
            totalItems: payload.description.totalCount
        };

        payload.items.forEach(function (item) {
            responseData['data'].push({
                type: 'customer-order',
                id: item.id,
                attributes: {
                    name: item.user.name,
                    surname: item.user.surname,
                    total: item.total,
                    created_at: item.created_at,
                },
            });
        });

        return responseData;
    },
    normalizeFindRecordResponse (store, primaryModelClass, payload){
        let object = payload[0];
        let responseData = {};
        responseData['data']= [];
        let responseAttrs = [];
        let responseRelationships = [];
        let included = [];
        let itemsArray = [];

        for(let propertyName in object){
            if(object.hasOwnProperty(propertyName)){
                switch (propertyName) {
                    case 'user':
                        responseRelationships[propertyName] = {
                            data: {
                                id:object[propertyName].id,
                                type: 'tcr-user'
                            }
                        };
                        included.push({
                            attributes:{
                                firstName: object[propertyName].name,
                                lastName:object[propertyName].surname,
                                email:   object[propertyName].email,
                                country:   object[propertyName].country
                            },
                            id: object[propertyName].id,
                            type: 'tcr-user'
                        });
                        break;
                    case 'items':
                        object[propertyName].forEach(function (item) {
                            itemsArray.push({
                                type: 'order-item',
                                id:    item.id
                            });
                            responseRelationships[propertyName] = {
                                data: itemsArray

                            };
                            included.push({
                                attributes:{
                                    created_at:              item.created_at,
                                    date_from:               item.date_from,
                                    date_to:                 item.date_to,
                                    number_of_months:        item.number_of_months,
                                    price_per_remaining_day: item.price_per_remaining_day,
                                    unit_price:              item.unit_price,
                                    product:                 item.product.name
                                },
                                id: item.id,
                                type: 'order-item'
                            });

                        });
                        break;
                    default :
                        responseAttrs[propertyName] = object[propertyName];
                        break;
                }
            }
        }

        responseData['data'] = {
            attributes: responseAttrs,
            id: object.id,
            type: 'customer-order',
            relationships: responseRelationships
        };

        responseData['included'] = included;

        console.log(responseData);

        return responseData;
    }
});
