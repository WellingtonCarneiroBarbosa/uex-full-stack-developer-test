<?php

return [
    'auth' => [
        'login' => [
            'title'           => 'Login',
            'remember-me'     => 'Remember me',
            'forgot-password' => 'Forgot your password?',
            'login'           => 'Log in',
            'have-no-account' => "Don't have an account yet?",
            'register-now'    => 'Register now!',
        ],

        'register' => [
            'title'              => 'Create Account',
            'create-account'     => 'Create Account',
            'already-registered' => 'Already have an account?',
            'login-now'          => 'Login now!',
        ],

        'forgot-password' => [
            'title'      => 'Forgot My Password',
            'disclaimer' => 'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.',
            'send'       => 'Send reset link',
        ],

        'reset-password' => [
            'title' => 'Reset Password',
        ],
    ],

    'profile' => [
        'title' => 'My Profile',

        'personal-information' => [
            'title'       => 'Profile Information',
            'description' => "Update your account's profile information and email address",

            'form' => [
                'new-photo'    => 'Select A New Photo',
                'remove-photo' => 'Remove Photo',

                'unverified'        => 'Your email address is unverified.',
                'verify-now'        => 'Click here to re-send the verification email.',
                'verification-sent' => 'A new verification link has been sent to your email address.',
            ],
        ],

        'update-password' => [
            'title'       => 'Update Password',
            'description' => 'Ensure your account is using a long, random password to stay secure',
        ],

        'two-f-auth' => [
            'title'       => 'Two Factor Authentication',
            'description' => 'Add additional security to your account using two factor authentication',

            'not-enabled-title'      => 'You have not enabled two factor authentication',
            'not-enabled-disclaimer' => "When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application",

            'enabled-title'      => 'You have enabled two factor authentication',
            'enabled-disclaimer' => "Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application or enter the setup key",

            'finish-title'      => 'Finish enabling two factor authentication',
            'finish-disclaimer' => "To finish enabling two factor authentication, scan the following QR code using your phone's authenticator application or enter the setup key and provide the generated OTP code",

            'setup-key' => 'Setup key',

            'save-keys' => "Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost",

            'regenerate'          => 'Regenerate Recovery Codes',
            'show-recovery-codes' => 'Show Recovery Codes',
        ],

        'sessions' => [
            'title'       => 'Browser Sessions',
            'description' => 'Manage and log out your active sessions on other browsers and devices',

            'disclaimer'    => 'If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password',
            'this-device'   => 'This device',
            'last-activity' => 'Last active',
            'logout'        => 'Log out other browser sessions',

            'modal' => [
                'description' => 'Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.',
            ],
        ],

        'delete-account' => [
            'title'       => 'Delete Account',
            'description' => 'Permanently delete your account',
            'disclaimer'  => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain',

            'are-you-sure' => "Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account",
        ],
    ],

    'contacts' => [
        'title'       => 'Contacts',
        'description' => 'Manage your contact list',

        'no-contacts' => "You don't have any contacts yet. Add one to get started",

        'any-contacts-found' => "No contacts found",

        'confirm-deleting' => [
            'title'       => 'Are you sure?',
            'description' => 'The contact :name will be permanently deleted!',
        ],

        'form' => [
            'common' => [
                'contact-information' => 'Contact Information',
                'address'             => 'Address',
            ],

            'create' => [
                'title'       => 'Add Contact',
                'description' => 'Enter the contact information to register',
            ],

            'edit' => [
                'title'       => 'Edit Contact',
                'description' => 'Update the contact information',
            ],
        ],
    ],

];
