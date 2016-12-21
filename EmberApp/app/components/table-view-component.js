import Ember from 'ember';
import LoadingStateMixin from '../mixins/loading-state';

export default Ember.Component.extend(LoadingStateMixin, {
    sortColumn: 'id',
    sortType: 'asc',
    defaultSortType: null,
    paramsArray: {
        groupOp: 'AND',
        rules: []
    },
    searchArray: [],
    eventBus: Ember.inject.service('event-bus'),

    actions: {
        goToPage: function (page) {
            page = (typeof page === 'string') ? (page === '+1' || page === '-1') ? (this.get('page') + parseInt(page)) : parseInt(page) : page;
            if (1 <= page && page <= this.get('maxPages')) {
                this.set('page', page);
                this.loadData(this.get('paramsArray'));
            }
        },
        handleFilterEntry(column, searchValue, compareType) {
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

    resetTable() {
        this.setProperties({
            sortColumn: 'id',
            sortType: this.get('defaultSortType') ? this.get('defaultSortType') : 'asc',
            page: 1,
            paramsArray: {
                groupOp: 'AND',
                rules: []
            },
            searchArray: []
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
