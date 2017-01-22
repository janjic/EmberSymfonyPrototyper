import Ember from 'ember';
const { inject: { service }, Component, computed } = Ember;
import { task, timeout } from 'ember-concurrency';

export default Component.extend({
    session:                service('session'),
    currentUser:            service('current-user'),
    store:                  service('store'),
    agentNotifications:     [],
    messageNotifications:   [],
    _maxIdMessage:          undefined,
    _maxIdAgents:           undefined,
    eventBus:               Ember.inject.service('event-bus'),
    noNewAgentNotifications:false,
    noNewMessageNotifications:false,

    init(){
        this._super(...arguments);
        this.set('isUserAdmin', this.get('currentUser.isUserAdmin'));

        let notifications = this.get('currentUser.user.notifications');
        if ( notifications.includes('optionAgent') || notifications.includes('optionPayment') ){
            this._initNotification();
        }

        if ( notifications.includes('optionMessage') ){
            this._initMessages();
        }
    },

    profileRoute: computed('user',function () {
        if (this.get('user.roles').includes('ROLE_SUPER_ADMIN')) {
                return 'dashboard.profile-settings';
        }
        return 'dashboard.agent.profile.profile-settings';
    }),
    actions: {
        logout() {
            this.get('session').invalidate();
        },
        transitionTo(notification, link){
            notification.set('isSeen', true);
            notification.save();
            this.get('transitionToRoute')(link);
        },
        transitionToRoute(route){
            this.get('transitionToRoute')(route);
        }
    },

    getNewMessage: task(function * () {
        let notifications = this.get('currentUser.user.notifications');
        if ( notifications.get('firstObject') ) {
            while (true) {
                yield timeout(10000);

                if ( notifications.includes('optionAgent') || notifications.includes('optionPayment') ) {
                    this.get('store').query('notification', {
                        per_page: 5,
                        page: 1,
                        type: 'NEW AGENT/PAYMENT NOTIFICATION',
                        max_id: this.get('_maxIdAgents')
                    }).then((newAgentNotifications) => {
                        if (newAgentNotifications.toArray().length && this.get('agentNotifications')) {
                            this.get('agentNotifications').unshiftObjects(newAgentNotifications.toArray());
                            this.get('agentNotifications').splice(5);
                            this.set('_maxIdAgents', newAgentNotifications.get('firstObject.id'));
                        }
                    });
                }

                if ( notifications.includes('optionMessage') ) {
                    this.get('store').query('notification', {
                        per_page: 5,
                        page: 1,
                        type: 'NEW MESSAGE NOTIFICATION',
                        max_id: this.get('_maxIdMessage')
                    }).then((newMessageNotification) => {
                        if (newMessageNotification.toArray().length && this.get('messageNotifications')) {
                            this.get('messageNotifications').unshiftObjects(newMessageNotification.toArray());
                            this.get('messageNotifications').splice(5);
                            this.set('_maxIdMessage', newMessageNotification.get('firstObject.id'));
                        }
                    });
                }
            }
        }
    }).on('init'),

    _initNotification(){
        this.get('store').query("notification", { per_page: 5, page: 1, type: 'NEW AGENT/PAYMENT NOTIFICATION' }).then((newAgentNotifications)=>{
            this.set( 'agentNotifications', [].concat(newAgentNotifications.toArray()) );
            this.set('_maxIdAgents', newAgentNotifications.get('firstObject.id'));
        }, ()=>{
            this.set('agentNotifications', []);
        });
    },

    _initMessages(){
        this.get('store').query("notification", { per_page: 5, page: 1, type: 'NEW MESSAGE NOTIFICATION' }).then((newMessageNotification)=>{
            this.set( 'messageNotifications', [].concat(newMessageNotification.toArray()) );
            this.set('_maxIdMessage', newMessageNotification.get('firstObject.id'));
        }, ()=> {
            this.set('messageNotifications', []);
        });
    },

    _initAllNotifications(){
        this._initNotification();
        this._initMessages();
    },

    _initialize: Ember.on('init', function(){
        this.get('eventBus').subscribe('refreshMessages', this, '_initAllNotifications');
    }),

    _teardown: Ember.on('willDestroyElement', function(){
        this.get('eventBus').unsubscribe('refreshMessages');
    })
});
