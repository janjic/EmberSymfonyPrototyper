import Ember from 'ember';
import InfinityRoute from "ember-infinity/mixins/route";

export default Ember.Mixin.create(InfinityRoute, {
    /**
     * Reset paremeters on thread change
     * @private
     */
    _resetInverseLoadParams() {
        this.set('isLoadedFirst', false);
        this.set('topScrollHolder', 0);
    },

    /** param used to stop content loading all at once */
    isLoadedFirst: false,
    /** holder for content height */
    topScrollHolder: 0,

    /**
     * When data is loaded scroll to bottom of div
     */
    afterInfinityModel(messages) {
        if (!this.get('isLoadedFirst')) {
            let element = this.$('#messages-list');
            setTimeout(() => {
                /** use difference of old and new height to calculate scroll */
                element.scrollTop(element[0].scrollHeight - this.get('topScrollHolder'));
                this.set('isLoadedFirst', true);
            }, 1);
        }

        this.set('_minId', messages.get('lastObject.id'));
    },

    /**
     * Override default function so it watches div top instead of bottom
     * @returns {boolean}
     * @private
     */
    _shouldLoadMore() {
        if (this.get('developmentMode') || this.isDestroying || this.isDestroyed) {
            return false;
        }
        let _topOffset = this.get('_scrollable').height() - this.get("_scrollable").scrollTop();
        return this._bottomOfScrollableOffset() <= _topOffset;
    },

    /**
     * Override default to save scroll div height as parameter and stop mulpiple loads
     */
    _infinityLoad() {
        if (this.get('_loadingMore') || !this.get('_canLoadMore') || !this.get('isLoadedFirst')) {
            return;
        }
        this.set('topScrollHolder', this.$('#messages-list')[0].scrollHeight);
        this.set('isLoadedFirst', false);
        this._loadNextPage();
    },
});
