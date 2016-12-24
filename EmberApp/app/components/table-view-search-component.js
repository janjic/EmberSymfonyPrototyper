import Ember from 'ember';

export default Ember.Component.extend({
    tagName: 'td',
    column: null,
    sortType: '',
    sortClass: 'fa-sort',
    compareType: '',
    searchValue: '',
    searchable: true,
    sortable: true,
    defaultDelayTime: 250,
    isSelect: Ember.computed('compareType', function () {
        return this.get('compareType')  === 'eq';
    }),
    isSearchable: Ember.computed('searchable', function () {
        return this.get('searchable')===undefined?true: this.get('searchable');

    }),
    isSortable: Ember.computed('sortable', function () {
        return this.get('sortable')===undefined?true: this.get('sortable');

    }),
    actions: {
        handleFilterEntry: function (delayTime) {
            delayTime = (delayTime === 0) ? 0 : this.get('defaultDelayTime');
            let search = this.get('searchValue').trim();
            if (this.get('isSelect')) {
                let selectedIndex = this.$('select')[0].selectedIndex;
                search = (this.get('compareValues')[selectedIndex - 1]) ? (this.get('compareValues')[selectedIndex - 1]).value : null;
            }
            this.get('filter').perform(this.get('column'), search, this.get('compareType'), delayTime);
        },
        removeSearch: function () {
            if (this.get('isSelect')) {
                this.$('select').val(-1);
            } else {
                this.set('searchValue', '');
            }
            this.set('sortColumn', 'id');
            this.set('sortType', this.get('defaultSortType') ? this.get('defaultSortType') : 'asc');
            this.set('sortClass', 'fa-sort');
            this.send('handleFilterEntry', 0);
        },
        sort: function () {
            Ember.$('.sorting i').removeClass('fa-sort-asc').removeClass('fa-sort-desc').addClass('fa-sort');
            let sortType = 'asc';
            let className = 'fa-sort-asc';
            if (this.get('sortClass') !== 'fa-sort' && this.get('sortClass') === 'fa-sort-asc') {
                sortType = 'desc';
                className = 'fa-sort-desc';
            }
            this.set('sortColumn', this.get('column'));
            this.set('sortType', sortType);
            this.set('sortClass', className);
            this.send('handleFilterEntry', 0);
        }
    }
});
