import Ember from 'ember';
import LoadingStateMixin from '../mixins/loading-state';
import { task, timeout } from 'ember-concurrency';

export default Ember.Component.extend(LoadingStateMixin, {
    defaultSortType: null,
    showSearchSortBar: true,
    defaultRules: [],
    searchArray: [],
    eventBus: Ember.inject.service('event-bus'),

    init(){
        this._super(...arguments);
        this.set('paramsArray', {
            groupOp: 'AND',
            rules: []
        });
        this.set('searchArray', [].concat(this.get('defaultRules')));
        if( this.get('searchArray') ){
            this.set('paramsArray.rules', this.get('searchArray'));
        }
        this.set('sortColumn', 'id');
        if ( this.get('initialSord') ){
            this.set('sortType', this.get('initialSord'));
        } else {
            this.set('sortType', 'asc');
        }
    },

    actions: {
        goToPage: function (page) {
            let currentPage = this.get('page');
            let maxPages = this.get('maxPages');
            page = (typeof page === 'string') ? (page === '+1' || page === '-1') ? (this.get('page') + parseInt(page)) : page : page;
            if ((page === '=1' && currentPage !== 1) || (page === '='+maxPages && currentPage !== maxPages) || (1 <= page && page <= maxPages)) {
                this.set('page', page === '=1' ? 1 : page === '='+maxPages ? maxPages : parseInt(page));
                this.loadData(this.get('paramsArray'));
            }
        },

        resetTableAction(){
            this.resetTable();
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
    }).restartable(),

    resetTable() {
        this.setProperties({
            sortColumn: 'id',
            sortType: this.get('defaultSortType') ? this.get('defaultSortType') : 'asc',
            page: 1,
            paramsArray: {
                groupOp: 'AND',
                rules: []
            },
            searchArray: this.get('defaultRules')
        });

        this.loadData(this.get('paramsArray'));
    },

    _initialize: Ember.on('init', function(){
        this.get('eventBus').subscribe('resetTableEvent', this, 'resetTable');
    }),

    _teardown: Ember.on('willDestroyElement', function(){
        this.get('eventBus').unsubscribe('resetTableEvent');
    })
});
