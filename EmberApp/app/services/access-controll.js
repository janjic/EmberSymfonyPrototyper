import Ember from 'ember';
const {
    RSVP,
    getOwner
} = Ember;

export default Ember.Service.extend({

    init (data=null) {
        let applicationInstance = getOwner(this);
        let registeredService = applicationInstance.lookup(`service:app-acl`);
        let roles = null;
        if (registeredService) {
             roles = !Object.is(data, null) ? data :registeredService.get('acl');
        } else {
             roles = {};
        }

        if(typeof roles === 'function') {
            roles = roles();
            this._init =  new RSVP.Promise((resolve)=> {
                resolve(roles);
            }).then(acl => {
                this.init(acl);
            });
            return;
        }


        if(typeof roles !== 'object') {
            throw new TypeError('Expected an object as input');
        }

        this.set('roles', roles);
        let map = {};
        Object.keys(roles).forEach(role => {
            map[role] = {
                can: {}
            };
            if(roles[role].inherits) {
                map[role].inherits = roles[role].inherits;
            }

            roles[role].can.forEach(operation => {
                if(typeof operation === 'string') {
                    map[role].can[operation] = 1;
                } else if(typeof operation.name === 'string' && typeof operation.when === 'function') {

                    map[role].can[operation.name] = operation.when;
                }
            });

        });

        this.set('roles', map);
        this.set('_inited',true);
    },

    create(acl) {
      return  this.init(acl);
    },

    can(role, operation, ...params){
        // If not inited then wait until init finishes
        if(!this.get('_inited')) {
            return this._init.then(()=> this.can(role, operation, params));
        }

        return  new RSVP.Promise((resolve, reject) =>{
            if (typeof role !== 'string') {
                throw new TypeError('Expected first parameter to be string : role');
            }

            if (typeof operation !== 'string') {
                throw new TypeError('Expected second parameter to be string : operation');
            }

            let $role = this.get('roles')[role];

            if (!$role) {
                throw new Error('Undefined role');
            }

            // IF this operation is not defined at current level try higher
            if (!$role.can[operation]) {
                // If no parents reject
                if (!$role.inherits ) {
                    return reject(false);
                }
                return RSVP.allSettled($role.inherits.map((parent) =>
                        this.can(parent, operation, params))).
                            then((array) =>array.find((el) => Object.is(el.state, 'fulfilled')) ? resolve(true) : reject(false),
                    ()=> reject(false));
            }

            // We have the operation resolve
            if ($role.can[operation] === 1) {
                return resolve(true);
            }

            // Operation is conditional, run async function
            if (typeof $role.can[operation] === 'function') {
                return $role.can[operation].apply(null,...params).then((data)=> resolve(true), (errors)=> reject(false));
            }
            // No operation reject as false
            return reject(false);
        });

    }
});
