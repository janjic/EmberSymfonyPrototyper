import Ember from 'ember';
const { download } = window;

export default Ember.Controller.extend({
    session: Ember.inject.service('session'),
    datesArray: [],
    maxDate: Ember.computed('model.items', function () {
        let ctx = this;
        this.get('model.items').forEach(function (item) {
            ctx.get('datesArray').push(new Date(item.get('date_to')).getTime());
        });

        return (new Date(Math.max.apply(null, this.get('datesArray')))).toISOString();
    }),
    actions: {
        downloadPDF(){
            /** set access token to ajax requests sent by orgchart library */
            let accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;

            Ember.$.ajaxSetup({
                beforeSend: (xhr) => {
                    accessToken = `Bearer ${this.get('session.data.authenticated.access_token')}`;
                    xhr.setRequestHeader('Authorization', accessToken);
                },
                headers: { 'Authorization': accessToken }
            });

            let id = this.get('model.id');

            $.ajax({
                type: "GET",
                url: "/api/order-print/"+id,
                contentType: "application/pdf",
            }).then(function (response) {
                download(response, "order-"+id+".pdf", "application/pdf");
            });
        }
    }
});
