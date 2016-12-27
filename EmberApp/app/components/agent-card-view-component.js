import Ember from 'ember';
import { task, timeout } from 'ember-concurrency';
import LoadingStateMixin from '../mixins/loading-state';
export default Ember.Component.extend(LoadingStateMixin,{
    limitAll: true,
    sortType: 'asc',
    defaultDelayTime: 250,
    columns: ['username', 'firstName', 'lastName'],
    compareType:'cn',
    sortColumn: 'id',
    searchValue: '',
    defaultSortType: null,
    showSearchSortBar: true,
    paramsArray: {
        groupOp: 'or',
        rules: []
    },
    searchArray: [],
    firstBtnClasses: "button dark icon-btn",
    secondBtnClasses: "button dark icon-btn",
    inputClasses:  Ember.computed('focusable', function () {
        if (!this.get('focusable')) {
            return 'form-control search-input';
        }
        return 'form-control search-input clicked';

    }),

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
    handleFilterEntry: task(function * () {
        let searchValue = this.get('searchValue').trim();
        let delayTime =  this.get('defaultDelayTime');
        yield timeout(delayTime);
        let searchArrayFields = this.get('searchArray');
        if (searchValue !== '') {
            this.get('columns').forEach((column) => {
                searchArrayFields.addObject({
                    field: column,
                    op: this.get('compareType'),
                    data: searchValue
                });
            });
        }
        let paramsArray = this.get('paramsArray');
        paramsArray.rules = searchArrayFields;
        this.set('page', 1);
        this.loadData(paramsArray);
        this.set('searchArray', []);
    }).restartable(),


    actions: {
        handlePageChange(page) {
            this.send('goToPage', page);
        },
        handleOffsetChange() {
            this.set('offset', this.$('select')[0].value);
            this.get('filter')(1);
        },
        goToPage(page) {
            let currentPage = this.get('page');
            let maxPages = this.get('maxPages');
            page = (typeof page === 'string') ? (page === '+1' || page === '-1') ? (this.get('page') + parseInt(page)) : page : page;
            if ((page === '=1' && currentPage !== 1) || (page === '='+maxPages && currentPage !== maxPages) || (1 <= page && page <= maxPages)) {
                this.set('page', page === '=1' ? 1 : page === '='+maxPages ? maxPages : parseInt(page));
                this.loadData(this.get('paramsArray'));
            }
        },
        addClickedClass() {
            this.set('focusable', true);
        },
        removeClickedClass (){
            this.set('focusable', false);
        },
        setSearch (input) {
            if (Object.is(parseInt(input), 1)) {
                this.set('firstBtnClasses', "button dark icon-btn green");
                this.set('secondBtnClasses', "button dark icon-btn");
            } else {
                this.set('firstBtnClasses', "button dark icon-btn");
                this.set('secondBtnClasses', "button dark icon-btn green");
            }
            this.toggleProperty('limitAll');
        }
    }
});
