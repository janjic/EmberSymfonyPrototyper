import Ember from 'ember';
const {
    RSVP,
} = Ember;
const roles =  {
    access_to_route: {
        can: [
            {
            name: 'dashboard',
            when: function (user, target) {
                return  new RSVP.Promise((resolve, reject) =>{
                    if (user.get('roles').includes('ROLE_SUPER_ADMIN')) {
                        /**
                         * Admin can not access agent pages
                         */
                        if (target.match(/dashboard.agent\..*/)) {
                            reject(false);
                        }

                    } else {
                        if (target.match(/dashboard\.agent\/.*/)) {
                            resolve(true);
                        } else {
                            reject(false);
                        }

                    }
                });
                }
            },
            {
            name: 'dashboard.agent.home',
            when: function (user) {
                    return  new RSVP.Promise((resolve, reject) =>{
                        if (user.get('roles').includes('ROLE_SUPER_ADMIN')) {
                            reject(false);
                        } else {
                            resolve(true);
                        }
                    });
                    }

            }

        ]

    },
    admin: {
        can: ['dashboard'],
        inherits: ['y']
    },
    y: {
        can: ['b'],
        inherits: ['z']
    },
    z: {
        can: ['c', {
            name: 'edit',
            when: function (a, b) {
                return  new RSVP.Promise((resolve, reject) =>{
                    if (Object.is(a,b)) {
                        resolve(true);
                    } else {
                        reject(false);
                    }
                });
            }
        }],
        inherits: ['f']
    },
    f: {
        can: ['d']
    }
};
export default Ember.Service.extend({
    acl () {
        return new Ember.RSVP.Promise((resolve)=> {
            resolve(roles);
        });
    }
});
