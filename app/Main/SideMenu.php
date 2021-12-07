<?php

namespace App\Main;

class SideMenu
{
    /**
     * List of side menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function menu()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'title' => 'Dashboard',
                'route_name' => 'dashboard',
                'role'  => 'member',
                'params' => [
                    'layout' => 'side-menu'
                ],
            ],
            'dashboard-admin' => [
                'icon' => 'home',
                'title' => 'Dashboard',
                'route_name' => 'dashboard.admin',
                'role'  => 'superadmin',
                'params' => [
                    'layout' => 'side-menu'
                ],
            ],
            'devider',
            'form_review_user' => [
                'icon' => 'file-text',
                'title' => 'Form Review',
                'route_name' => 'form-review.user.index',
                'role'  => 'member',
                'params' => [
                    'layout' => 'side-menu'
                ],
            ],

            'form_review' => [
                'icon' => 'file-text',
                'title' => 'Form Review',
                'role' => 'superadmin',
                'sub_menu' => [
                    'form-pending' => [
                        'icon' => '',
                        'route_name' => 'form-pending.index',
                        'role' => 'superadmin',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Need Review'
                    ],
                    'form-accept' => [
                        'icon' => '',
                        'route_name' => 'form-accept.index',
                        'role' => 'superadmin',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Waiting List'
                    ],
                    'form-reject' => [
                        'icon' => '',
                        'route_name' => 'form-reject.index',
                        'role' => 'superadmin',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Rejected'
                    ],
                ]
            ],
            'topup' => [
                'icon' => 'pocket',
                'title' => 'Transaksi',
                'role' => 'superadmin',
                'sub_menu' => [
                    'pocket-history' => [
                        'icon' => '',
                        'route_name' => 'topupHistory.admin',
                        'role' => 'superadmin',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Topup User'
                    ],
                    'refund-history' => [
                        'icon' => '',
                        'route_name' => 'refund-user.index',
                        'role' => 'superadmin',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Refund User'
                    ]
                ]
            ],
            'support' => [
                'icon' => 'message-circle',
                'title' => 'Support',
                'role' => 'member|superadmin',
                'sub_menu' => [
                    'chat' => [
                        'title' => 'Live Chat',
                        'role' => 'superadmin|member',
                        'route_name' => 'chat.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'open-ticket' => [
                        'title' => 'Open Ticket',
                        'role' => 'member',
                        'route_name' => 'createTicket',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'my-ticket' => [
                        'title' => 'My Ticket',
                        'role' => 'member',
                        'route_name' => 'myTicket',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'user-list-ticket' => [
                        'title' => 'User Ticket',
                        'role' => 'superadmin',
                        'route_name' => 'userTicket.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ]
            ],
            
            'devider',
            'user_control' => [
                'icon' => 'users',
                'title' => 'User Control',
                'route_name' => 'balance-control.index',
                'role'  => 'superadmin',
                'params' => [
                    'layout' => 'side-menu'
                ],
            ],
            'app_control' => [
                'icon' => 'settings',
                'title' => 'General Setting',
                'role'  => 'superadmin',
                'sub_menu' => [
                    'mail-setting' => [
                        'icon' => '',
                        'route_name' => 'mailSetting',
                        'role' => 'superadmin',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Mail Setting'
                    ],
                    'topup-setting' => [
                        'icon' => '',
                        'route_name' => 'topupSetting',
                        'role' => 'superadmin',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Topup Setting'
                    ],
                    'app-setting' => [
                        'icon' => '',
                        'route_name' => 'appSetting',
                        'role' => 'superadmin',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Apps Setting'
                    ],
                    'bank-setting' => [
                        'icon' => '',
                        'route_name' => 'listBank',
                        'role' => 'superadmin',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Bank Setting'
                    ],
                ]
            ],
            'pocket' => [
                'icon' => 'pocket',
                'title' => 'Balance',
                'role' => 'member',
                'sub_menu' => [
                    'pocket-topup' => [
                        'icon' => '',
                        'route_name' => 'topupView',
                        'role' => 'member',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Topup'
                    ],
                    'pocket-refund' => [
                        'icon' => '',
                        'route_name' => 'index.refund',
                        'role' => 'member',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Refund'
                    ],
                    'pocket-history' => [
                        'icon' => '',
                        'route_name' => 'topupHistory',
                        'role' => 'member',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'History Topup'
                    ],
                    'pocket-used-history' => [
                        'icon' => '',
                        'route_name' => 'historyBalance',
                        'role' => 'member',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'History Penggunaan Balance'
                    ],
                    'pocket-history-refund' => [
                        'icon' => '',
                        'route_name' => 'historyRefund',
                        'role' => 'member',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'History Refund'
                    ],
                ]
            ],

            'setting_user' => [
                'icon' => 'settings',
                'title' => 'Setting',
                'role'  => 'member',
                'sub_menu' => [
                    'bank-setting' => [
                        'icon' => '',
                        'route_name' => 'user.bank.index',
                        'role' => 'member',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Bank Setting'
                    ],
                ]
            ],
            
            

        ];
    }
}
