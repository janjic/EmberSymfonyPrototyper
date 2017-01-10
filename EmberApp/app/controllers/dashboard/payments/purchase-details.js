import Ember from 'ember';

export default Ember.Controller.extend({
    session: Ember.inject.service('session'),
    datesArray: [],
    maxDate: Ember.computed('model.items', function () {
        let ctx = this;
        this.get('model.items').forEach(function (item) {
            ctx.get('datesArray').push(new Date(item.get('date_to')).getTime());
        });

        return (new Date(Math.max.apply(null, this.get('datesArray')))).toString();
    }),
    actions: {
        downloadPDF(){
            /** set access token to ajax requests sent by orgchart library */
            let accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
            console.log(accessToken);
            Ember.$.ajaxSetup({
                beforeSend: (xhr) => {
                    accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
                    xhr.setRequestHeader('Authorization', accessToken);
                },
                headers: { 'Authorization': accessToken }
            });


            $.ajax({
                type: "GET",
                url: "/api/order-print/43",
                contentType: "application/pdf",
            }).then(function (response) {
                console.log(response);
            });

            // window.open('/api/order-print/43');
            //
            // console.log('usao');
        }
    }
});
