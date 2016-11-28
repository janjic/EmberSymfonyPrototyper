import Ember from 'ember';
const {
    RSVP,
} = Ember;
const roles =  {
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
