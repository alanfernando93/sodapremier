<?php

namespace App\Controller\Admin;

use \App\Controller\AppController;
use Cake\Event\Event;

/**
 * Admin Controller
 *
 */
class AdminController extends AppController {

    public function initialize() {
        parent::initialize();
        // Existing code
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ]
                ]
            ],
//            'loginAction' => [
//                'controller' => 'Users',
//                'action' => 'login'
//            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            // If unauthorized, return them to page they were just on
            'unauthorizedRedirect' => $this->referer()
        ]);

        // Allow the display action so our PagesController
        // continues to work. Also enable the read only actions.
        $this->Auth->allow(['view', 'index']);
    }

    public function beforeRender(Event $event) {
        $this->viewBuilder()->setLayout('admin');
    }
    
    public function beforeFilter(Event $event) {
        $this->viewBuilder()->setLayout('admin');
    }

    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // By default deny access.
        return false;
    }

}