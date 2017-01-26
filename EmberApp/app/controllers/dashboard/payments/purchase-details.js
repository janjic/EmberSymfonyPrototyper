import Ember from 'ember';
const { download } = window;
const { Routing } = window;

export default Ember.Controller.extend({
    session: Ember.inject.service('session'),
    maxDate: Ember.computed('model.items', function () {
        let ctx = this;
        this.get('model.items').forEach(function (item) {
            ctx.get('datesArray').push(new Date(item.get('date_to')).getTime());
        });

        return (new Date(Math.max.apply(null, this.get('datesArray')))).toISOString();
    }),
    actions: {
        downloadPDF(){
            this.set('isPDFLoading', true);
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
            let ctx = this;

            Ember.$.ajax({
                type: "GET",
                url: Routing.generate('order_print', {'id': id}),
                contentType: "application/pdf",
            }).then(function (response) {
                download(response, "order-"+id+".pdf", "application/pdf");
                ctx.set('isPDFLoading', false);
            });
        }
    }
});
