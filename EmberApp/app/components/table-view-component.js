import Ember from 'ember';
import LoadingStateMixin from '../mixins/loading-state';
import { task, timeout } from 'ember-concurrency';

export default Ember.Component.extend(LoadingStateMixin, {
    sortColumn: 'id',
    sortType: 'asc',
    paramsArray: {
        groupOp: 'AND',
        rules: []
    },
    searchArray: [],
    actions: {
        goToPage: function (page) {
            let currentPage = this.get('page');
            let maxPages = this.get('maxPages');
            page = (typeof page === 'string') ? (page === '+1' || page === '-1') ? (this.get('page') + parseInt(page)) : page : page;
            if ((page === '=1' && currentPage !== 1) || (page === '='+maxPages && currentPage !== maxPages) || (1 <= page && page <= maxPages)) {
                this.set('page', page === '=1' ? 1 : page === '='+maxPages ? maxPages : parseInt(page));
                this.loadData(this.get('paramsArray'));
            }
        }
    },
    loadData: function (paramsArray){
        this.showLoader();
        let result = this.get('filter')(paramsArray, this.get('page'), this.get('sortColumn'), this.get('sortType'));
        if (result) {
            result.then((filterResults) => {
                this.set('model', filterResults);
                this.set('maxPages', filterResults.meta.pages);
                this.disableLoader();
            }).catch(() => {
                this.disableLoader();
            });
        } else {
            this.disableLoader();
        }
    },
    handleFilterEntry: task(function * (column, searchValue, compareType, delayTime) {
        yield timeout(delayTime);
        let searchArrayFields = this.get('searchArray');
        let exists = searchArrayFields.findBy('field', column);
        if (exists !== undefined) {
            if (searchValue === '') {
                searchArrayFields.removeObject(exists);
            } else {
                exists.data = searchValue;
            }
        } else {
            if (searchValue !== '') {
                searchArrayFields.addObject({
                    field: column,
                    op: compareType,
                    data: searchValue
                });
            }
        }
        let paramsArray = this.get('paramsArray');
        paramsArray.rules = searchArrayFields;
        this.set('page', 1);
        this.loadData(paramsArray);
    }).restartable()
});
