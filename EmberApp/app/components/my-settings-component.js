import Ember from 'ember';
import SettingsValidations from '../validations/my-settings';
import CommissionValidations from '../validations/commission';
import Changeset from 'ember-changeset';
import lookupValidator from './../utils/lookupValidator';

export default Ember.Component.extend({
    SettingsValidations,
    CommissionValidations,
    isValidCommisions:      [true],
    isValidBonus:           [true],

    init(){
        this._super(...arguments);
        this.changeset = new Changeset(this.get('settings'), lookupValidator(SettingsValidations), SettingsValidations);
    },

    actions: {
        saveSettings(){
            this.get('changeset').validate();
            let validCommissions = this.get('isValidCommisions').every((valid)=>valid===true);
            let validBonuses = this.get('isValidBonus').every((valid)=>valid===true);
            if (this.get('changeset').get('isValid') && validCommissions && validBonuses) {
                this.get('settings').save().then(()=>{
                    this.toast.success('update je');
                }, ()=>{
                    this.toast.error('greska');
                });
                console.log('user saved');
                return;
            }

            console.log('user not saved');
            console.log(this.get('isValidCommisions')+' , '+this.get('isValidBonus'));
        },
        validateProperty(changeset, property) {
            return changeset.validate(property);
        },
        validateCommissionsProperty(isSubPropertyValid, index){
            this.get('isValidCommisions')[index] = isSubPropertyValid;
        },
        validateBonusProperty(isSubPropertyValid, index){
            this.get('isValidBonus')[index] = isSubPropertyValid;
        }
    }
});
