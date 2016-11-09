import Ember from 'ember';
import config from './config/environment';

const Router = Ember.Router.extend({
  location: config.locationType,
  rootURL: config.rootURL
});

Router.map(function() {
  this.route('login', function() {
    this.route('forgot');
  });
  this.route('protected');
  this.route('auth-error');
  this.route('about');
  this.route('simple');
  this.route('user-profile');

  this.route('dashboard', function() {
    this.route('users-all');
    this.route('add-new-user');
    this.route('add-new-agent');
    this.route('all-agents');
    this.route('agent-update-history');
    this.route('tree-view');
    this.route('table-view');
    this.route('folder-view');
    this.route('home');
    this.route('payouts-to-agents');
    this.route('reports');
    this.route('add-new-mail-list');
    this.route('all-mail-lists');
    this.route('add-mm-campaign');
    this.route('all-mm-campaigns');
    this.route('received-messages');
    this.route('drafts');
    this.route('sent');
    this.route('trash');
    this.route('settings');
    this.route('all-tickets');
    this.route('users-customers');
    this.route('settings', function() {
        this.route('manage-user-groups');
        this.route('manage-roles');
    });
  });
});

export default Router;
