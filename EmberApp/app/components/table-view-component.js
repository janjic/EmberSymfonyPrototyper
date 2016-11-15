import Ember from 'ember';

export default Ember.Component.extend({
    sortColumn: 'id',
    sortType: 'asc',
    paramsArray: {
        groupOp: 'AND',
        rules: []
    },
    searchArray: [],
    actions: {
        goToPage: function (page) {
            page = (typeof page === 'string') ? (page === '+1' || page === '-1') ? (this.get('page') + parseInt(page)) : parseInt(page) : page;
            if (1 <= page && page <= this.get('maxPages')) {
                this.set('page', page);
                var result = this.get('filter')(this.get('paramsArray'), page, this.get('sortColumn'), this.get('sortType'));
                if (result) {
                    result
                        .then((filterResults) => this.set('model', filterResults) && this.set('maxPages', filterResults.meta.pages))
                        .catch((result) => console.log(result));
                }
            }
        },
        handleFilterEntry(column, searchValue, compareType) {
            var searchArrayFields = this.get('searchArray');
            var exists = searchArrayFields.findBy('field', column);
            if (exists !== undefined) {
                if (!searchValue) {
                    searchArrayFields.removeObject(exists);
                } else {
                    exists.data = searchValue;
                }
            } else {
                if (searchValue) {
                    searchArrayFields.addObject({
                        field: column,
                        op: compareType,
                        data: searchValue
                    });
                }
            }
            var paramsArray = this.get('paramsArray');
            paramsArray.rules = searchArrayFields;
            this.set('page', 1);
            this.get('filter')(paramsArray, 1, this.get('sortColumn'), this.get('sortType'))
                .then((filterResults) => this.set('model', filterResults)  && this.set('maxPages', filterResults.meta.pages))
                .catch((result) => console.log(result));
        }
    }
});
