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
    this.route('users-customers');
    this.route('home');
    this.route('settings');
    this.route('payments', function() {
      this.route('purchase-details');
      this.route('reports');
      this.route('payouts-to-agents');
    });

    this.route('agents', function() {
      this.route('add-new-agent');
      this.route('all-agents');
      this.route('agent-update-history');
      this.route('agent-view');
      this.route('agent-edit');
    });

    this.route('mass-mails', function() {
      this.route('add-new-mail-list');
      this.route('all-mail-lists');
      this.route('add-new-campaign');
      this.route('all-campaigns');
      this.route('edit-mail-list');
      this.route('edit-campaign');
    });

    this.route('messages', function() {
      this.route('create-message');
      this.route('drafts');
      this.route('create-message-edit');
      this.route('received-messages');
      this.route('sent');
      this.route('sent-messages');
      this.route('trash');
      this.route('view-message');
    });
  });

  this.route('dashboard-agent', function() {
    this.route('home');

    this.route('profile', function() {
      this.route('profile-settings');
      this.route('messages');
    });

    this.route('users', function() {
      this.route('add-new-user');
      this.route('users-customers');
    });
  });
});

export default Router;
