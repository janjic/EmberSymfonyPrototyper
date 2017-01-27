// template-to-string.js
import Ember from 'ember';
export default function(template, applicationInstance, data, domElement= null) {
    let layout = applicationInstance.lookup(template);
    let container = applicationInstance.container;
    let renderer = applicationInstance.lookup('renderer:-dom');
    return new Ember.RSVP.Promise((resolve) =>{
        // create a new component
        let component = Ember.Component.create({
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

            resolve(el);
            if (domElement) {
                domElement.append(el);
            }

            this.destroy();
        });

        // append the component to the body to make it render
        component.append();
    });
}
