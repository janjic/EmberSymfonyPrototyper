import Ember from 'ember';

export default Ember.Mixin.create({
    searchTree(items, element){
        for(let i=0; i < items.get('length'); i++){
            let item = items.objectAt(i);
            if (Object.is(Number.parseInt(item.get('id')), Number.parseInt(element.get('id')))) {
                return item;
            }  else if (item.get('children').get('length')) {
                let result = this.searchTree(item.get('children'), element);
                if (result) {
                    return result;
                }
            }
        }

        return null;
    },
    deleteItemFromModel(item)
    {
        if (!Object.is(this.get('items').indexOf(item), -1)) {
            this.get('items').removeAt(this.get('items').indexOf(item));
        }
    },
    findMyPrevAndUpdate(item) {
        // let oldParentId = item.get('parent')?item.get('parent').get('id'):null;
        let oldParent = item.get('parent') ? item.get('parent') : null;
        let collection = oldParent ? oldParent.get('children') : this.get('items');
        let indexOf = collection.indexOf(item);
        let prevEl = collection.objectAt(indexOf-1);
        item.set('prev', prevEl ? prevEl.get('id') : null);
        item.save().then(()=>{
            this.toggleProperty('needRefresh');
        });
    },
    whoIsMyPrev(object) {
        object = Ember.Object.create(object);
        let item = this.searchTree(this.get('items'), Ember.Object.create({id:object.get('id')}));
        let oldParentId = item.get('parent')?item.get('parent').get('id'):null;
        let oldParent =   oldParentId? item.get('parent') :null;
        let newParentId =  object.get('parent') ?object.get('parent'):null;
        let newParent = newParentId ? this.searchTree(this.get('items'), Ember.Object.create({id:newParentId})) :undefined;

        let prevElement;
        let prevPosition;

        prevElement = (newParent && object.get('prev')) ? newParent.get('children').find((pEl, index) =>{
            if (Object.is(Number.parseInt(pEl.get('id')), Number.parseInt(object.get('prev')))) {
                prevPosition= index;
                return true;
            }
            return false;
        }): (object.get('prev')? this.get('items').find((pEl, index) =>{
            if (Object.is(Number.parseInt(pEl.get('id')), Number.parseInt(object.get('prev')))) {
                prevPosition= index;
                return true;
            }
            return false;
        }):prevElement);

        let insertPosition = !isNaN(prevPosition) ?prevPosition+1 :0;
        let oldCollection = oldParent ?  oldParent.get('children'): this.get('items');
        let oldElementPosition = oldCollection.indexOf(item);
        let isSameParent = Object.is(Number.parseInt(oldParentId), Number.parseInt(newParentId));
        let isSamePosition = Object.is(Number.parseInt(insertPosition), Number.parseInt(oldElementPosition));
        if (!isSameParent || (isSameParent &&  !isSamePosition))
        {
            oldCollection.removeAt(oldElementPosition);

            if (newParent) {
                prevPosition = !isNaN(prevPosition) ? newParent.get('children').indexOf(prevElement) : prevPosition;
                insertPosition = !isNaN(prevPosition) ?prevPosition+1 :0;
                newParent.get('children').insertAt(insertPosition, item);
                item.set('parent', newParent);
            } else {
                prevPosition = !isNaN(prevPosition) ? this.get('items').indexOf(prevElement) : prevPosition;
                insertPosition = !isNaN(prevPosition) ?prevPosition+1 :0;
                this.get('items').insertAt(insertPosition,item);
            }
            item.set('prev', prevElement ?prevElement.get('id'):null);
            item.set('parent', newParent);

            this.processItemUpdate(item);
        }
    },

    processItemUpdate(item) {
        this.toggleProperty('needRefresh');
        item.save().then(()=>{
            this.toggleProperty('needRefresh');
        });
    },
});
