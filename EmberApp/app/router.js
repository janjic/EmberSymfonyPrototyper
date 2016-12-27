import Ember from 'ember';
import config from './config/environment';

const Router = Ember.Router.extend({
    location: config.locationType,
    rootURL: config.rootURL
});

Router.map(function() {
  this.route('login', function() {
      this.route('forgot');
      this.route('new-password', { path: '/new-password/:token' });
  });
  this.route('protected');
  this.route('auth-error');
  this.route('about');
  this.route('simple');
  this.route('user-profile');

  this.route('dashboard', function() {
      this.route('home');
      this.route('profile-settings');
      this.route('settings', function() {
        this.route('manage-user-groups');
        this.route('manage-roles');
        this.route('my-settings');
      });
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
          this.route('agent-edit', {path: '/agent-edit/:id'});
      });

      this.route('mass-mails', function() {
          this.route('add-new-mail-list');
          this.route('all-mail-lists');
          this.route('add-new-campaign');
          this.route('all-campaigns');
          this.route('edit-mail-list', {path: '/mail-list-edit/:id'});
          this.route('edit-campaign', {path: '/replicate-campaign/:id'});
      });


      this.route('messages', function() {
          this.route('create-message');
          this.route('received-messages');
          this.route('sent');
          this.route('trash');
          this.route('drafts');
      });

      this.route('users', function() {
          this.route('all-tickets');
          this.route('ticket-details', {path: '/ticket-details/:id'});
          this.route('user-view', {path: '/user-view/:id'});
          this.route('users-customers');
          this.route('users-all');
          this.route('user-add');
          this.route('user-edit', {path: '/user-edit/:id'});
      });

      this.route('agent', function() {
          this.route('home');
          this.route('genealogy-tree');
          this.route('messages', function() {
              this.route('create-message');
              this.route('received-messages');
              this.route('sent');
              this.route('trash');
              this.route('drafts');
          });
          this.route('profile', function() {
              this.route('profile-settings');
          });
          this.route('tickets', function() {
            this.route('tickets-all');
            this.route('new-ticket');
            this.route('view-ticket', {path: '/view-ticket/:id'});
            this.route('created-tickets');
          });
          this.route('reports', function() {
              this.route('customer-orders');
              this.route('commissions');
              this.route('purchase-details');
          });
          this.route('wallet', function() {
              this.route('wallet-summary');
              this.route('payout-history');
          });
          this.route('users', function() {
              this.route('add-new-user');
              this.route('users-customers');
              this.route('user-edit');
              this.route('user-view');
          });
          this.route('agents', function() {
              this.route('add-new-agent');
          });
      });

      this.route('genealogy-tree');
      this.route('notifications-all');
  });

  this.route('files');
});

export default Router;