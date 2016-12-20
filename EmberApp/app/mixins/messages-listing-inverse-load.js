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
    afterInfinityModel(data) {
        if (!this.get('isLoadedFirst')) {
            let element = this.$(this.get('scrollContainer'));
            setTimeout(() => {
                /** use difference of old and new height to calculate scroll */
                element.scrollTop(element[0].scrollHeight - this.get('topScrollHolder'));
                this.set('isLoadedFirst', true);
            }, 1);
        }

        this.set('_minId', data.get('lastObject.id'));
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

        /** if scrolled to bottom */
        if ((this._bottomOfScrollableOffset() >= this.get('_scrollable')[0].scrollHeight) && this.get('eventBus')) {
            this.get('eventBus').publish('hideNewMessagesText');
        }

        return this._bottomOfScrollableOffset() <= _topOffset;
    },

    /**
     * Override default to save scroll div height as parameter and stop mulpiple loads
     */
    _infinityLoad() {
        if (this.get('_loadingMore') || !this.get('_canLoadMore') || !this.get('isLoadedFirst')) {
            return;
        }
        this.set('topScrollHolder', this.$(this.get('scrollContainer'))[0].scrollHeight);
        this.set('isLoadedFirst', false);
        this._loadNextPage();
    },

    /**
     * Override default to save scroll div height as parameter and stop mulpiple loads
     */
    _doUpdate(newObjects) {
      let infinityModel = this._infinityModel();
      return infinityModel.pushObjects(newObjects.toArray());
    },

    scrollToBottom(){
      let element = this.$(this.get('scrollContainer'));
      setTimeout(() => {
          element.scrollTop(element[0].scrollHeight);
      }, 1);
    }
});
