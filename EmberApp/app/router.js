import Ember from 'ember';
import config from './config/environment';

const Router = Ember.Router.extend({
  location: config.locationType,
  rootURL: config.rootURL
});

Router.map(function() {
  this.route('login');
  this.route('protected');
  this.route('auth-error');
  this.route('about');
  this.route('simple');
  this.route('user-profile');
  this.route('dashboard-users-all');
});

export default Router;
