/*jshint node:true*/
/* global require, module */
var EmberApp = require('ember-cli/lib/broccoli/ember-app');

module.exports = function(defaults) {
  var app = new EmberApp(defaults, {
      'ember-cli-bootstrap-sassy': {
          'js': false
      },
      SemanticUI: {
          // These flags allow you do turn on or off auto imports for Semantic UI
          import: {
              css: true,
              javascript: true,
              images: true,
              fonts: true
          },
          // These settings allow you to specify the source of the Semantic files
          source: {
              css: 'bower_components/semantic-ui/dist',
              javascript: 'bower_components/semantic-ui/dist',
              images: 'bower_components/semantic-ui/dist/themes/default/assets/images',
              fonts: 'bower_components/semantic-ui/dist/themes/default/assets/fonts'
          },
          // These settings allow you to specify the destination of the Semantic files
          // This only applies to images and fonts, since those are assets
          destination: {
              images: 'assets/themes/default/assets/images',
              fonts: 'assets/themes/default/assets/fonts'
          }
      }
  });

  // Use `app.import` to add additional libraries to the generated
  // output files.
  //
  // If you need to use different assets in different
  // environments, specify an object as the first parameter. That
  // object's keys should be the environment name and the values
  // should be the asset to use in that environment.
  //
  // If the library that you are including contains AMD or ES6
  // modules that you would like to import into your application
  // please specify an object with the list of modules as keys
  // along with the exports of each module as its value.
  app.import('vendor/nestable.js');
  app.import('vendor/highcharts.js');
  app.import('vendor/bundles/bazingajstranslation/main.js');
  app.import('vendor/bundles/fosjsrouting/main.js');
  app.import('vendor/bundles/core/js/api-codes.js');
  app.import('vendor/frontend-scripts.js');

  app.import('vendor/Rubik-Bold.ttf', {
      destDir: 'fonts'
  });

  app.import('vendor/Rubik-Medium.ttf', {
      destDir: 'fonts'
  });
  app.import('vendor/Rubik-Regular.ttf', {
      destDir: 'fonts'
  });

  app.import("bower_components/orgchart/dist/js/jquery.orgchart.js");
  app.import("bower_components/orgchart/dist/css/jquery.orgchart.css");

  return app.toTree();
};
