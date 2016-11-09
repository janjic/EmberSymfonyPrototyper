/*jshint node:true*/
/* global require, module */
var EmberApp = require('ember-cli/lib/broccoli/ember-app');

module.exports = function(defaults) {
  var app = new EmberApp(defaults, {
    // Add options here
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
  app.import('vendor/bootstrap.min.js');
  app.import('vendor/bootstrap.min.css');
  app.import('vendor/font-awesome.min.css');

  app.import('vendor/fontawesome-webfont.woff2', {
    destDir: 'fonts'
  });
  app.import('vendor/fontawesome-webfont.woff', {
    destDir: 'fonts'
  });

  app.import('vendor/fontawesome-webfont.ttf', {
    destDir: 'fonts'
  });

  app.import('vendor/fontawesome-webfont.svg', {
    destDir: 'fonts'
  });

  app.import('vendor/fontawesome-webfont.eot', {
    destDir: 'fonts'
  });

  app.import('vendor/jqGrid/css/jquery-ui.css');
  app.import('vendor/jqGrid/css/ui.jqgrid.css');
  app.import('vendor/jqGrid/js/i18n/grid.locale-en.js');
  app.import('vendor/jqGrid/js/jquery.jqGrid.min.js');
  app.import('vendor/jqGrid/js/jQgrid-universal.js');
  app.import('vendor/bundles/bazingajstranslation/main.js');
  app.import('vendor/bundles/fosjsrouting/main.js');

  app.import('vendor/glyphicons-halflings-regular.eot', {
    destDir: 'fonts'
  });
  app.import('vendor/glyphicons-halflings-regular.ttf', {
    destDir: 'fonts'
  });
  app.import('vendor/glyphicons-halflings-regular.svg', {
    destDir: 'fonts'
  });

  app.import('vendor/glyphicons-halflings-regular.woff', {
    destDir: 'fonts'
  });
  app.import('vendor/glyphicons-halflings-regular.woff2', {
    destDir: 'fonts'
  });

  return app.toTree();
};
