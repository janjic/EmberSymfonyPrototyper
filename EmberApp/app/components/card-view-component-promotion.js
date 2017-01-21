import Ember from 'ember';
import { task, timeout } from 'ember-concurrency';


export default Ember.Component.extend({
    limitAll: true,
    sortType: 'asc',
    defaultDelayTime: 250,
    columns: ['username', 'firstName', 'lastName'],
    compareType:'cn',
    sortColumn: 'id',
    searchValue: '',
    defaultSortType: null,
    showSearchSortBar: true,
    showAddAgentButton: true,
    firstBtnClasses: "button dark icon-btn",
    secondBtnClasses: "button dark icon-btn",
    inputClasses:  Ember.computed('focusable', function () {
        //FOR NOW WE CAN CHANGE THIS LATER
        if (!this.get('focusable')) {
            return 'form-control search-input clicked';
        }
        return 'form-control search-input clicked';

    }),

    loadData: function (paramsArray){
        let result = this.get('filter')(paramsArray, this.get('page'), this.get('maxPages'),this.get('sortColumn'), this.get('sortType'));
        if (result) {
            result.then((filterResults) => {
                this.set('model', filterResults.data);
                this.set('maxPages', filterResults.meta.pages);
                this.set('meta.page', filterResults.meta.page);
            }).catch(() => {
                });
        }
    },
    handleFilterEntry: task(function * (letter) {
        let searchValue;
        if (letter) {
            searchValue = letter;
            this.set('searchValue', searchValue);
        } else {
            searchValue = this.get('searchValue');
        }
        if (!letter) {
            let delayTime =  this.get('defaultDelayTime');
            yield timeout(delayTime);
        }
        let searchArrayFields = this.get('searchArray');
        if (searchValue !== '') {
            this.get('columns').forEach((column) => {
                searchValue.split(' ').forEach((searchVal) => {
                    if (!Ember.isEmpty(searchVal.trim())) {
                        searchArrayFields.addObject({
                            field: column,
                            op: this.get('compareType'),
                            data: searchVal.trim()
                        });
                    }
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
            this.set('searchValue', '');
            this.get('handleFilterEntry').perform();
            if (Object.is(parseInt(input), 1)) {
                this.set('limitAll', true);
                this.set('firstBtnClasses', "button dark icon-btn green");
                this.set('secondBtnClasses', "button dark icon-btn");
            } else {
                this.set('limitAll', false);
                this.set('firstBtnClasses', "button dark icon-btn");
                this.set('secondBtnClasses', "button dark icon-btn green");
            }
        },
        agentSelected(agent){
            this.get('agentSelected')(agent);
        }
    },

    search: task(function * (text, page, perPage) {
        yield timeout(200);
        return this.get('searchQuery')(page, text, perPage);
    }),

    init() {
        this.set('paramsArray', {
            groupOp: 'or',
            rules: []
        });
        this.set('searchValue', '');
        this.set('searchArray', []);
        this._super(...arguments);
    }
});
