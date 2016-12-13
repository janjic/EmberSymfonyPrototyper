import Ember from 'ember';
import SearchableSelect from 'ember-searchable-select/components/searchable-select';
import { task } from 'ember-concurrency';
const menuSelector = '.Searchable-select__options-list-scroll-wrapper';
export default SearchableSelect.extend({

    classNames: ['Searchable-select-infinite'],
    classNameBindings: [
        '_isShowingMenu:Searchable-select--menu-open',
        'multiple:Searchable-select--multiple'
    ],

    content: null,
    selected: null,
    optionLabelKey: null,
    optionDisabledKey: null,
    sortBy: null,
    limitSearchToWordBoundary: false,
    multiple: false,
    closeOnSelection: true,

    prompt: 'Select an option',
    searchPrompt: 'Type to search',
    noResultsMessage: 'No matching results',

    isClearable: true,
    clearLabel: 'Clear',

    addLabel: 'Add',

    isLoading: false,
    loadingMessage: 'Searching...',
    _searchText: '',
    _isShowingMenu: false,
    _hasSelection: Ember.computed.notEmpty('_selected'),
    _isShowingClear: Ember.computed.and('isClearable', '_hasSelection'),
    _hasNoResults: Ember.computed.empty('_filteredContent'),
    _hasResults: Ember.computed.not('_hasNoResults'),
    _isNotLoading: Ember.computed.not('isLoading'),
    _isSingleSelect: Ember.computed.not('multiple'),
    _hasMultipleSelection: Ember.computed.and('multiple', '_hasSelection'),
    _hasSingleSelection: Ember.computed.and('_isSingleSelect', '_hasSelection'),
    _isSearchable: Ember.computed('_isFilterActive', function() {
        return !this.get('_isFilterActive') || this.get('searchable');
    }),
    _isShowingAddNew: Ember.computed.and(
        '_canAddNew',
        '_hasNoMatchedKeys',
        '_searchText'),

    _isShowingNoResultsMessage: Ember.computed.and(
        '_searchText',
        '_hasNoResults',
        '_isNotLoading'),

    'on-change': Ember.K,
    'on-add': Ember.K,
    'on-search': Ember.K,
    'on-close': Ember.K,
    'on-remove': Ember.K,

    _isFilterActive: Ember.computed('on-search', function() {
        return this.get('on-search') === Ember.K;
    }),

    _canAddNew: Ember.computed('on-add', function() {
        return this.get('on-add') !== Ember.K;
    }),

    _canRemove: Ember.computed('on-remove', function() {
        return this.get('on-remove') !== Ember.K;
    }),

    _canChangeSelected: Ember.computed('on-change', function() {
        return this.get('on-change') !== Ember.K;
    }),

    _itemsPerPage : Ember.computed('perPage',function () {
        if (!this.get('perPage')) {
            return 8;
        }
        return this.get('perPage');
    }),

    // Make the passed in `selected` a one-way binding.
    // `Ember.computed.oneWay` won't pick up on upstream
    // changes after the prop gets set internally.

    // TODO  refactor into two CP's, one for single _selected,
    // one for _multiselected
    _selected: Ember.computed('selected', 'selected.[]', {
        get() {
            if (this.get('multiple') && !this.get('selected')) {
                // coerce null multiple selections to an empty array
                return Ember.A([]);
            } else if (this.get('multiple') && !Array.isArray(this.get('selected'))) {
                throw new Error('passed in multiple selection must be an array');
            } else {
                return this.get('selected');
            }
        },
        set(key, value) {
            return value;
        }
    }),

    _sortArray: Ember.computed('sortBy', function() {
        if (this.get('sortBy')) {
            return this.get('sortBy').replace(' ', '').split(',');
        }
        return [];
    }),

    _filterRegex: Ember.computed(
        'limitSearchToWordBoundary',
        '_searchText',
        function() {
            let searchText = this.get('_searchText');

            if (searchText) {
                let regex = this.get('limitSearchToWordBoundary') ?
                    `\\b${searchText}` : searchText;
                return new RegExp(regex, 'i');
            }
        }
    ),

    _filteredContent: Ember.computed(
        'content.[]',
        'optionLabelKey',
        '_filterRegex',
        '_isFilterActive',
        function() {
            let filterRegex = this.get('_filterRegex');
            let content = this.get('content');
            if (filterRegex && this.get('_isFilterActive')) {
                return Ember.A(content.filter(item => {
                    if (this.get('optionLabelKey')) {
                        return filterRegex.test(Ember.get(item, this.get('optionLabelKey')));
                    }
                    return filterRegex.test(item);

                }));
            } else {
                return content;
            }
        }),

    _filteredKeys: Ember.computed(
        '_filteredContent',
        'optionLabelKey',
        function() {
            let optKey = this.get('optionLabelKey');
            return optKey ? Ember.A(this.get('_filteredContent').mapBy(optKey)) : Ember.A(this.get('_filteredContent'));
        }
    ),

    _hasMatchedKey: Ember.computed('_filteredKeys', '_searchText', function() {
        let regex = new RegExp(`^${this.get('_searchText')}$`, 'i');

        return this.get('_filteredKeys').filter((key) => {
            return regex.test(key);
        }).length;
    }),

    _hasNoMatchedKeys: Ember.computed.not('_hasMatchedKey'),

    _setup: Ember.on('didInsertElement', function() {

        this.$().on('keydown', e => {
            this._handleKeyboardControls(e);
        });
    }),

    handleAsyncSearchTask: task(function* (text, page, searchThenable) {
        try {
            let result = yield searchThenable;
            this.setDataAfterSearch(result);
        } catch(e) {
        } finally {
            if (typeof searchThenable.cancel === 'function') {
                searchThenable.cancel();
            }
        }
    }).restartable(),

    setDataAfterSearch (results){
        if (this.get('isLoadingMore')) {
            // prepend the previous results
            const previousResults = this.get('content');
            this.set('content', results.toArray().unshiftObjects(previousResults));
        } else {
            this.set('content', results);
        }

        // meta should include keys for "total", "page" and "pages"
        this.set('meta', results.get('meta'));
        //Example
        // this.set('meta', {
        //     total: 3,
        //     page: 1,
        //     pages: 10
        // });
        // done loading
        this.set('isLoading', false);
        this.set('isLoadingMore', false);
    },
    // cache menu height, no need to measure it on every scroll
    _menuHeight: Ember.computed('_filteredContent.length', '_isShowingMenu', function() {
        if (!this.get('_isShowingMenu')) {
            return 0;
        }

        const menu = this.$(menuSelector);
        if (!menu.length) {
            return 0;
        }

        return menu.height();
    }),

    resultCountMessage: 'result',
    loadingMoreMessage: 'Searching more results...',
    moreMessage: 'More results available',
    noMoreMessage: 'No more results',

    autoloadMore: true,
    isLoadingMore: false,
    _isLoading: Ember.computed('isLoading', 'isLoadingMore', function() {
        const isLoading = this.get('isLoading');
        const isLoadingMore = this.get('isLoadingMore');
        return isLoading && !isLoadingMore;
    }),

    showResultCount: true,
    _isShowingResultCount: Ember.computed.and('showResultCount', 'meta.total', '_searchText'),

    showSearchClear: true,
    _isShowingSearchClear: Ember.computed.and('showSearchClear', '_searchText'),

    meta: null,
    _resultCount: Ember.computed('meta.total', function() {
        return parseInt(this.get('meta.total'), 10);
    }),
    _currentPage: Ember.computed('meta.page', function() {
        return parseInt(this.get('meta.page'), 10);
    }),
    _totalPages: Ember.computed('meta.pages', function() {
        return parseInt(this.get('meta.pages'), 10);
    }),

    _hasMeta: Ember.computed.bool('meta'),
    _hasMore: Ember.computed('_currentPage', '_totalPages', function() {
        const currentPage = this.get('_currentPage') || 0;
        const totalPages = this.get('_totalPages') || 0;
        return currentPage < totalPages;
    }),
    _hasNoMore: Ember.computed.not('_hasMore'),

    _bindOutsideClicks() {
        let component = this;
        let componentElem = this.get('element');
        component.$(window).on(`click.${component.elementId}`, function(e) {
            if (!window.$.contains(componentElem, e.target)) {
                component.send('hideMenu');
                component.$('.Searchable-select__label').blur();
            }
        });
    },

    _unbindOutsideClicks() {
        let component = this;
        component.$(window).off(`click.${component.elementId}`);
    },

    _handleKeyboardControls(e) {
        let component = this;
        let $focussable = this.$('[tabindex]');
        let i = $focussable.index(e.target);

        if (e.keyCode === 40) {
            // down arrow
            e.preventDefault();
            $focussable.eq(i + 1).focus();

            if (component.$(e.target).is('.Searchable-select__label')) {
                this.send('showMenu');
            }
        } else if (e.keyCode === 38) {
            // up arrow
            e.preventDefault();
            if (i > 0) {
                $focussable.eq(i - 1).focus();
            }
        } else if (e.keyCode === 27 || e.keyCode === 9) {
            // escape key or tab key
            this.send('hideMenu');
        } else if (e.keyCode === 13) {
            // enter key
            let action = component.$(e.target).attr('data-enter-key-action');

            if (action) {
                this.send(action);
            }
        }
    },

    _toggleSelection(item) {
        if (item === null) {
            this.set('_selected', Ember.A([]));
        } else if (Ember.A(this.get('_selected')).contains(item)) {
            this.removeFromSelected(item);
        } else {
            this.addToSelected(item);
        }
    },

    // non-mutating adding and removing to/from the _selected array
    removeFromSelected(item) {
        let selected = this.get('_selected');
        let i = selected.indexOf(item);
        let newSelection = selected.slice(0, i).concat(selected.slice(i + 1));
        this.set('_selected', Ember.A(newSelection));
    },
    addToSelected(item) {
        this.set('_selected', Ember.A(this.get('_selected').concat([item])));
    },


    _bindMenuScroll() {
        if (this.get('autoloadMore')) {
            const component = this;
            component.$(menuSelector).on(`scroll.${component.elementId}`, function(event) {
                Ember.run.debounce(component, '_debouncedMenuScroll', event.target, 50);
            });
        }
    },

    _unbindMenuScroll() {
        const component = this;
        component.$(menuSelector).off(`scroll.${component.elementId}`);
    },

    _debouncedMenuScroll(target) {
        const isLoading = this.get('isLoading');
        const isLoadingMore = this.get('isLoadingMore');
        const isShowingMenu = this.get('_isShowingMenu');
        if (isLoading || isLoadingMore || !isShowingMenu) {
            return;
        }

        const menu = this.$(target);
        const more = menu.find('.Searchable-select__more-label');
        const height = this.get('_menuHeight');

        if (!more.length || !menu.length || !height) {
            return;
        }

        const scrollPosition = more.offset().top - menu.offset().top - height;
        const hasMore = this.get('_hasMore');
        const shouldSearchMore = hasMore && scrollPosition < 0;

        if (shouldSearchMore && !this.get('_isFilterActive')) {
            this.send('searchMore');
        }
    },

    actions: {
        // override for scrolling wrapper to top
        updateSearch(text) {
            this.set('_searchText', text);
            if (!this.get('_isFilterActive')) {
                this.send('search', text, 1);
            }
            Ember.run.scheduleOnce('afterRender', this, function() {
                this.$(menuSelector).scrollTop(0);
            });
        },

        clearSearch() {
            this.set('_searchText', '');
            this.$('.Searchable-select__input').val('').focus().keyup();
        },

        searchMore() {
            const searchText = this.get('_searchText');
            const nextPage = this.get('_currentPage') + 1;
            this.set('isLoadingMore', true);
            this.send('search', searchText, nextPage);
        },

        toggleMenu() {
            if (this.get('_isShowingMenu')) {
                this.send('hideMenu');
            } else {
                this.send('showMenu');
            }
        },

        selectItem(item) {
            let disabledKey = this.get('optionDisabledKey');

            if (item && disabledKey && Ember.get(item, disabledKey)) {
                // item is disabled, do nothing
                return;
            }

            if (this.get('multiple')) {
                // add or remove item from selection
                this._toggleSelection(item);
            } else {
                // replace selection
                this.set('_selected', item);
            }
            if (!this.get('_canChangeSelected')) {
                throw new Error('on-change is not provided !');
            }
            this.get('on-change')(this.get('_selected'));

            if (this.get('closeOnSelection')) {
                this.send('hideMenu');
            }
        },

        // override for binding scroll
        showMenu() {
            this.set('_isShowingMenu', true);

            Ember.run.scheduleOnce('afterRender', this, function() {
                this.$('.Searchable-select__input').focus();
            });

            Ember.run.next(this, function() {
                this._bindOutsideClicks();
                this._bindMenuScroll();
            });
        },

        // override for unbinding scroll
        hideMenu() {
            this._unbindMenuScroll();
            this._unbindOutsideClicks();

            this.set('_isShowingMenu', false);
            this.set('_searchText', '');
            this.$('.Searchable-select__label').focus();
        },

        clickResultCountLabel() {
            this.$('.Searchable-select__input').focus();
        },

        search(text, page = 1) {
                // reset search on empty text
                if (!text.trim()) {
                    this.set('isLoading', false);
                    this.set('isLoadingMore', false);
                    this.set('content', null);
                    this.set('meta', null);
                    return;
                }

                // set the loading indicator
                this.set('isLoading', true);
                // search for something on the store
                // presume that it takes a "page" parameter for requesting a specific page
                // presume it returns a "meta" with the results
            let search =  this.get('on-search')(text, page, this.get('_itemsPerPage'));
            if (!search) {
                this.setDataAfterSearch([]);
            } else if (search.then) {
                this.get('handleAsyncSearchTask').perform(text, page, search);
            } else {
                this.setDataAfterSearch(search);
            }

        },

        clear() {
            this.send('selectItem', null);
        },
        removeOption(option) {
            this.removeFromSelected(option);
            if (this.get('_canRemove')) {
                throw new Error('On remove must be provided');
            }
            this.get('on-remove')(this.get('_selected'));
        },

        addNew() {
            if (!this.get('_canAddNew')) {
                this.get('on-add')(this.get('_searchText'));
            }
            if (this.get('closeOnSelection')) {
                this.send('hideMenu');
            }
        },

        noop() {
            // need an action to able to attach bubbles:false to an elem
        }
    }
});