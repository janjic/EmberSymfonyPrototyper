// template-to-string.js
import Ember from 'ember';
// when you call this function
// app initialization must be finished
export default function(template, applicationInstance, data, destroy=false, el= null) {
    let layout = applicationInstance.lookup(template);
    let container = applicationInstance.container;
    let renderer = applicationInstance.lookup('renderer:-dom');
    return new Ember.RSVP.Promise((resolve) =>{
        // create a new component
        let component = Ember.Component.create({
            style: 'display:none;', // hide it
            layout, // specify your template as a layout
            renderer,
            container // provide container
        });
        if (data) {
            Ember.merge(component, data);
        }

        // subscribing to didRender event
        component.on('didRender', function() {
            // no we can grab the result of rendering
            let el = component.element.innerHTML;
            // remove the component
            if (destroy) {
                this.destroy();
            }

            resolve(el);
        });

        // append the component to the body to make it render
        el ? component.appendTo(el): component.append();

    })
}
