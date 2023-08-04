<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Email templating languages Lines
    |--------------------------------------------------------------------------
    |
    */

    'email_title'                                   => 'Email title',
    'role_type'                                     => 'Role type',
    'all_templates'                                 => 'Email templates',
    'add_email_template'                            => 'Add new template',
    'update_email_template'                         => 'Update template',
    'select_template'                               => 'Select template',
    'registration_title'                            => 'Registration email',
    'buyer'                                         => 'Buyer',        
    'seller'                                        => 'Seller',        
    'admin'                                         => 'Admin',        
    'verfiy_email'                                  => 'Verify Email Address',
    'login_url'                                     => '“Login”',
    'ridirect_login'                                => 'Redict to login',
    'set_email_status'                              => 'Set this email status as',
    'reset_password_txt'                            => 'Reset password',
    // =========== Email general translation ==================== \\ 
    'email_setting_variable'                        => 'Email setting variables',
    'greeting'                                      => 'Greeting text',
    'email_content'                                 => 'Email content',
    'subject'                                       => 'Email subject',

    // =========================== User Registration by admin notify user  =============== \\
    'user_created_title'                            => 'New user Created',

    'user_created_variables'                        => '{{user_name}} — To display the user name.<br> {{site_name}} — To display the site name. <br> {{user_email}} — To display the user email. {{password}} To display the user password.',
    'user_created_subject'                          => 'New account created',
    'user_created_greeting'                         => 'Hi {{user_name}},',
    'user_created_content'                          => 'Great news! Your new account has been created by the admin of {{site_name}} <br> Please login with the details mentioned below. <br>Email address:<br>{{user_email}}<br>Password:<br>{{password}}<br>Thanks,<br>{{admin_name}}',

    // ===========================User Registration Email =============== \\
    'buyer_registration_email_variable'             => '{{user_name}} — To display the user name.<br>{{user_email}} — To display the user email.<br>{{user_password}} — To display the user password.<br>{{site_name}} — To display the sitename.<br> {{verification_link}} — To display the verification url link',        
    'buyer_registration_subject'                    => 'Thank you for registration at {{site_name}}',        
    'buyer_registration_greeting'                   => 'Hello {{user_name}}',        
    'buyer_registration_content'                    => 'Thank you for the registration at {{site_name}}. Please click below to verify your email <br> {{verification_link}}',

    'seller_registration_email_variable'            => '{{user_name}} — To display the user name.<br> {{user_email}} — To display the user email.<br> {{user_password}} — To display the user password.<br>{{site_name}} — To display the sitename.<br>  {{verification_link}} — To display the verification url link',        
    'seller_registration_subject'                   => 'Thank you for registration at {{site_name}}', 
    'seller_registration_greeting'                  => 'Hello {{user_name}}',
    'seller_registration_content'                   => 'Thank you for the registration at {{site_name}}. Please click below to verify your email <br> {{verification_link}}',

    'user_registerd_to_admin_variable'              => '{{user_name}} — To display the user name.<br>{{user_email}} — To display the user email.',
    'user_registerd_to_admin_subject'               => 'Thank you for registration at {{site_name}}', 
    'user_registerd_to_admin_greeting'              => 'Hello,',
    'user_registerd_to_admin_content'               => 'A new user has been registered on the site with the name <br> "{{user_name}}" and email address "{{user_email}}"',

    //========================= Account approval request =========================\\
    'account_approval_title'                        => 'Account approval request',
    
    'buyer_account_approval_variables'              => '{{user_name}} — To display the user name.<br> {{user_email}} — To display the user email.<br>{{user_password}} — To display the user password.<br>{{site_name}} — To display the sitename.',
    'buyer_account_approval_subject'                => 'Thank you for registration at {{site_name}}',
    'buyer_account_approval_greeting'               => 'Hello {{user_name}},',
    'buyer_account_approval_content'                => 'Thank you for the registration at {{site_name}}. Your account will be approved  after the verification.',
    
    'seller_account_approval_variables'             => '{{user_name}} — To display the user name.<br> {{user_email}} — To display the user email.<br>{{user_password}} — To display the user password.<br>{{site_name}} — To display the sitename.',
    'seller_account_approval_subject'               => 'Thank you for registration at {{site_name}}',
    'seller_account_approval_greeting'              => 'Hello {{user_name}},',
    'seller_account_approval_content'               => 'Thank you for the registration at {{site_name}}. Your account will be approved  after the verification.',

    'admin_account_approval_variables'              => '{{user_email}} — To display the user email.<br>{{user_password}} — To display the user password.<br>{{site_name}} — To display the sitename.<br>{{login_url}} — User Login URL.',
    'admin_account_approval_subject'                => 'Thank you for registration at {{site_name}}',
    'admin_account_approval_greeting'               => 'Hello,',
    'admin_account_approval_content'                => 'A new user has been registered on the site with the name {{user_name}} and email address {{user_email}}. <br> The registration is pending for approval, you can login {{login_url}} to the admin to approve the account',
    
    //========================= Account approved =========================\\ (done)
    'account_approved_title'                        => 'Account approved',

    'buyer_account_approved_variables'              => '{{user_name}} — To display the user name.<br>{{user_email}} — To display the user email.<br>{{site_name}} — To display the sitename.',
    'buyer_account_approved_subject'                => 'Account approved.',
    'buyer_account_approved_greeting'               => 'Hello {{user_name}},',
    'buyer_account_approved_content'                => 'Congratulations! Your account has been approved by the admin.',

    'seller_account_approved_variables'             => '{{user_name}} — To display the user name.<br>{{user_email}} — To display the user email.<br>{{site_name}} — To display the sitename.',
    'seller_account_approved_subject'               => 'Account approved.',
    'seller_account_approved_greeting'              => 'Hello {{user_name}},',
    'seller_account_approved_content'               => 'Congratulations! Your account has been approved by the admin.',

    //=========================== Reset password ================================\\ (Done)

    'reset_password'                                => 'Reset password',

    'buyer_reset_password_variables'                => '{{account_email}} — To display the user email. <br> {{reset_link}} — To display reset password URL link.',
    'buyer_reset_password_subject'                  => 'Reset password.',
    'buyer_reset_password_greeting'                 => 'Hello,',
    'buyer_reset_password_content'                  => 'Someone requested to reset the password of following account: <br> Email Address: {{account_email}} <br>If this was a mistake, just ignore this email and nothing will happen.<br>To reset your password, click reset link below:<br>{{reset_link}}',

    'seller_reset_password_variables'               => '{{account_email}} — To display the user email. <br> {{reset_link}} — To display reset password URL link.',
    'seller_reset_password_subject'                 => 'Reset password.',
    'seller_reset_password_greeting'                => 'Hello,',
    'seller_reset_password_content'                 => 'Someone requested to reset the password of following account: <br> Email Address: {{account_email}} <br>If this was a mistake, just ignore this email and nothing will happen.<br>To reset your password, click reset link below:<br>{{reset_link}}',
    //===================================== Account identity request to Admin - for admin ====================\\ (done)
    'accout_identity_verification'                  => 'Account identity verification',

    'identity_verification_variables'               => '{{user_name}} — To display the user name.<br> {{login_url}} — User Login URL',
    'identity_verification_subject'                 => 'A new request receiver for identity verification',
    'identity_verification_greeting'                => 'Hello,',
    'identity_verification_content'                 => '{{user_name}} uploaded document for identity verification. The account verification is pending for approval, you can {{login_url}} to the admin to approve the identity verfication.',
    //===================================== Account identity rejection ====================\\ (done)
    'accout_identity_rejection'                     => 'Account identity rejection',

    'buyer_identity_rejection_variables'            => '{{user_name}} — To display the user name.<br>{{user_link}} — To display the user link who send the identity verification.<br>{{admin_message}} — To display the admin message for rejection.<br>{{user_email}} — To display the user email address who send the identity verification request.',
    'buyer_identity_rejection_subject'              => 'Your request for identity verification has been rejected',
    'buyer_identity_rejection_greeting'             => 'Hello {{user_name}},',
    'buyer_identity_rejection_content'              => 'You uploaded document for identity verification has been rejected.<br>{{admin_message}}',

    'seller_identity_rejection_variables'           => '{{user_name}} — To display the user name.<br>{{user_link}} — To display the user link who send the identity verification.<br>{{admin_message}} — To display the admin message for rejection.<br>{{user_email}} — To display the user email address who send the identity verification request.',
    'seller_identity_rejection_subject'             => 'Your request for identity verification has been rejected',
    'seller_identity_rejection_greeting'            => 'Hello {{user_name}},',
    'seller_identity_rejection_content'             => 'You uploaded document for identity verification has been rejected.<br>{{admin_message}}',
    
    //====================================== Account identity approved ========================= \\ (Done)
    'account_identity_approved'                     => 'Account identity approved',

    'buyer_identity_approved_variables'             => '{{user_name}} — To display the user name.<br>{{user_link}} — To display the user link who send the identity verification.<br>{{user_email}} — To display the user email address who send the identity verification request.',
    'buyer_identity_approved_subject'               => 'Your request for identity verification has been approved',
    'buyer_identity_approved_greeting'              => 'Hello {{user_name}},',
    'buyer_identity_approved_content'               => 'Congratulations!<br>Your submitted documents for the identity verification has been approved.',

    'seller_identity_approved_variables'            => '{{user_name}} — To display the user name.<br>{{user_link}} — To display the user link who send the identity verification.<br>{{user_email}} — To display the user email address who send the identity verification request.',
    'seller_identity_approved_subject'              => 'Your request for identity verification has been approved',
    'seller_identity_approved_greeting'             => 'Hello {{user_name}},',
    'seller_identity_approved_content'              => 'Congratulations!<br>Your submitted documents for the identity verification has been approved.',

    // ============================ When new dispute is created by buyer to seller ============ \\ (Done)
    'seller_dispute_received'                       => 'Dispute Created by buyer to seller',

    'seller_dispute_received_variables'             => '{{user_name}} — To display the seller name.<br> {{buyer_name}} — To display the buyer name.<br> {{project_title}} — To display the project title.<br> {{buyer_comments}} — To display the buyer comments. <br/> {{login_url}} — User Login URL',
    'seller_dispute_received_subject'               => 'A new refund request received',
    'seller_dispute_received_greeting'              => 'Hello {{user_name}}',
    'seller_dispute_received_content'               => "You've received a refund request from {{buyer_name}} against the project “{{project_title}}”.<br>{{buyer_comments}} </br> You can approve or decline the refund request. <br> {{login_url}}",
    // ============================ When dispute approved by seller to buyer ============ \\ (Done)
    'seller_approved_dispute_req'                   => 'Refund approved by seller',

    'seller_approved_dispute_req_variables'         => '{{user_name}} — To display the user name. <br> {{sender_name}} — To display the seller name.<br> {{project_title}} — To display the project title.',
    'seller_approved_dispute_req_subject'           => 'Refund approved',
    'seller_approved_dispute_req_greeting'          => 'Hello {{user_name}},',
    'seller_approved_dispute_req_content'           => "Congratulations! <br> Your refund request has been approved by the {{sender_name}} against the project “{{project_title}}”",
    // ============================ When dispute declined by seller to buyer ============ \\ (Done)
    'seller_decline_dispute'                        => 'Refund declined from seller',

    'seller_decline_dispute_variables'              => '{{user_name}} — To display the user name.<br> {{sender_name}} — To display the sender name.<br> {{project_title}} — To display the project title. <br/> {{login_url}} — User Login URL',
    'seller_decline_dispute_subject'                => 'Refund declined',
    'seller_decline_dispute_greeting'               => 'Hello {{user_name}}',
    'seller_decline_dispute_content'                => "Your refund request has been declined by the {{sender_name}} against the project “{{project_title}}”<br>If you think that this was a valid request then you can raise a dispute from the ongoing project activity page. <br> {{login_url}}",

    // ============================ comment on refund request ============ \\ (Done)
    'comment_on_dispute'                            => 'Refund comments',

    'seller_dispute_comment_variables'              => '{{user_name}} — To display the user name.<br> {{sender_name}} — To display the sender name.<br> {{project_title}} — To display the project title. <br> {{sender_comments}} — To display the comment. <br> {{login_url}} — User Login URL.',
    'seller_dispute_comment_subject'                => 'A new comment on refund request',
    'seller_dispute_comment_greeting'               => 'Hello {{user_name}}',
    'seller_dispute_comment_content'                => "The “{{sender_name}}” has left some comments on the refund request against the project “{{project_title}}”<br>{{sender_comments}} <br> {{login_url}}",

    'buyer_dispute_comment_variables'               => '{{user_name}} — To display the user name.<br> {{sender_name}} — To display the sender name.<br> {{project_title}} — To display the project title. <br> {{sender_comments}} — To display the comment. <br> {{login_url}} — User Login URL.',
    'buyer_dispute_comment_subject'                 => 'A new comment on refund request',
    'buyer_dispute_comment_greeting'                => 'Hello {{user_name}}',
    'buyer_dispute_comment_content'                 => "The “{{sender_name}}” has left some comments on the refund request against the project “{{project_title}}”<br>{{sender_comments}} <br> {{login_url}}",
 
// ============================ new dispute received to admin ============ \\ (Done)
    'admin_received_dispute'                        => 'Dispute received to admin',
    'admin_received_dispute_variables'              => "{{project_title}} — To display the project title.<br> {{type}} — To display the type like 'project' or 'gig'",
    'admin_received_dispute_subject'                => 'A new dispute received',
    'admin_received_dispute_greeting'               => 'Hello',
    'admin_received_dispute_content'                => "A new dispute has been created against the {{type}} “{{project_title}}”",

// ============================ dispute refunded in hourly project by admin to winner  ============ \\ (Done)
    'admin_refund_hourly_dispute_to_winner'         => 'Hourly project dispute in winner favour',
    
    'hourly_dispute_favour_in_seller_variables'     => '{{user_name}} — To display the seller name.',
    'hourly_dispute_favour_in_seller_subject'       => 'Dispute resolved',
    'hourly_dispute_favour_in_seller_greeting'      => 'Hello {{user_name}},',
    'hourly_dispute_favour_in_seller_content'       => "Congratulations! <br> We have gone through the refund and dispute and resolved the dispute in your favor. We disputed the project.",

    'hourly_dispute_favour_in_buyer_variables'      => '{{user_name}} — To display the seller name.',
    'hourly_dispute_favour_in_buyer_subject'        => 'Dispute resolved',
    'hourly_dispute_favour_in_buyer_greeting'       => 'Hello {{user_name}},',
    'hourly_dispute_favour_in_buyer_content'        => "Congratulations! <br> We have gone through the refund and dispute and resolved the dispute in your favor. We disputed the project.",

// ============================ dispute refunded in fixed and milestone project by admin to winner  ============ \\ (Done)
    'admin_refund_dispute_to_winner'                => 'Project dispute in winner favour',
    
    'dispute_favour_in_seller_variables'            => '{{user_name}} — To display the seller name.',
    'dispute_favour_in_seller_subject'              => 'Dispute resolved',
    'dispute_favour_in_seller_greeting'             => 'Hello {{user_name}},',
    'dispute_favour_in_seller_content'              => "Congratulations! <br> We have gone through the refund and dispute and resolved the dispute in your favor. We disputed the project and the amount has been added to your account.",

    'dispute_favour_in_buyer_variables'             => '{{user_name}} — To display the seller name.',
    'dispute_favour_in_buyer_subject'               => 'Dispute resolved',
    'dispute_favour_in_buyer_greeting'              => 'Hello {{user_name}},',
    'dispute_favour_in_buyer_content'               => "Congratulations! <br> We have gone through the refund and dispute and resolved the dispute in your favor. We disputed the project and the amount has been added to your account.",

    // ============================ dispute refunded by admin to not in favour  ============ \\ (Done)
    'admin_dispute_not_in_favour'                   => 'Project dispute not in favour',

    'dispute_not_in_favour_seller_variables'        => '{{user_name}} — To display the buyer name. <br> {{dispute_link}} — Dispute URL Link',
    'dispute_not_in_favour_seller_subject'          => 'Dispute resolved',
    'dispute_not_in_favour_seller_greeting'         => 'Hello {{user_name}},',
    'dispute_not_in_favour_seller_content'          => "Oho! We did not approve the dispute refund request in your favor.<br>Please click on the button below to view the dispute details.<br>{{dispute_link}}",

    'dispute_not_in_favour_buyer_variables'         => '{{user_name}} — To display the buyer name. <br> {{dispute_link}} — Dispute URL Link',
    'dispute_not_in_favour_buyer_subject'           => 'Dispute resolved',
    'dispute_not_in_favour_buyer_greeting'          => 'Hello {{user_name}},',
    'dispute_not_in_favour_buyer_content'           => "Oho! We did not approve the dispute refund request in your favor.<br>Please click on the button below to view the dispute details.<br>{{dispute_link}}",

    // ============================ package purchase - for seller and buyer ============ \\ (Done)
    'package_purchase'                              => 'Package purchase',

    'package_purchase_by_seller_variables'          => '{{user_name}} — To display the user name.<br>{{package_name}} — To display the package name.',
    'package_purchase_by_seller_subject'            => 'Thank you for purchasing the package',
    'package_purchase_by_seller_greeting'           => 'Hello {{user_name}},',
    'package_purchase_by_seller_content'            => 'Thank you for purchasing the package “{{package_name}}”<br>You can now post a service and get orders',

    'package_purchase_by_buyer_variables'           => '{{user_name}} — To display the user name.<br>{{package_name}} — To display the package name.',
    'package_purchase_by_buyer_subject'             => 'Thank you for purchasing the package',
    'package_purchase_by_buyer_greeting'            => 'Hello {{user_name}},',
    'package_purchase_by_buyer_content'             => 'Thank you for purchasing the package “{{package_name}}”<br>You can now create jobs.',

    'package_purchase_to_admin_variables'           => '{{user_name}} — To display the user name.<br>{{package_name}} — To display the package name.<br> {{purchaser_name}} — To display the package name.<br>{{current_date}} — To display the purchase date.',
    'package_purchase_to_admin_subject'             => 'New package purchased by “{{purchaser_name}}”',
    'package_purchase_to_admin_greeting'            => 'Hello,',
    'package_purchase_to_admin_content'             => 'A new purchase of “{{package_name}}” has been made by “{{purchaser_name}}” on “{{current_date}}”',

    // ============================ send message on project conversation ============ \\ (Done)
    'project_conversation'                          => 'Project conversation',

    'seller_project_conv_var'                       => '{{user_name}} — To display the user name.<br>{{sender_name}} — To display the sender name.<br> {{project_title}} — To display the project title. <br> {{login_url}} — User Login URL.',
    'seller_project_conv_subj'                      => 'A new message received',
    'seller_project_conv_greeting'                  => 'Hello {{user_name}}',
    'seller_project_conv_cont'                      => "{{sender_name}} sent you a new message on a project “{{project_title}}”.<br>Click the link below to read the message.<br>{{login_url}}",

    'buyer_project_conv_var'                        => '{{user_name}} — To display the user name.<br> {{sender_name}} — To display the sender name.<br>{{project_title}} — To display the project title. <br> {{login_url}} — User Login URL.',
    'buyer_project_conv_subj'                       => 'A new message received',
    'buyer_project_conv_greeting'                   => 'Hello {{user_name}}',
    'buyer_project_conv_cont'                       => "{{sender_name}} sent you a new message on a project “{{project_title}}”.<br>Click the link below to read the message.<br>{{login_url}}",
     
    // ============================ Project submission when verification by admin and sent to buyer - for buyer and admin(Done) ============ \\ (Done)
    'project_posted'                                => 'Project submission',

    'project_posted_by_buyer_variables'             => '{{user_name}} — To display the user name.',
    'project_posted_by_buyer_subject'               => 'Project submission',
    'project_posted_by_buyer_greeting'              => 'Hello {{user_name}},',
    'project_posted_by_buyer_content'               => 'Thank you for submitting the project, we will review and approve the project after the review.',
    'project_posted_to_admin_variables'             => '{{user_name}} — To display the user name.<br>{{project_link}} — To project preview URL.',
    'project_posted_to_admin_subject'               => 'New project submission',
    'project_posted_to_admin_greeting'              => 'Hello,',
    'project_posted_to_admin_content'               => 'New project submitted by “{{user_name}}” and waiting for approval. Please click the below link for further details.<br> {{project_link}}',

    // ============================ Project invite request from buyer to seller - for seller ============ \\ (Done)
    'project_invite_request'                        => 'Sent project invite',

    'project_invite_request_variables'              => '{{user_name}} — To display the user name. <br> {{project_title}} — To display the project title.',
    'project_invite_request_subject'                => 'You have received invitation to a project',
    'project_invite_request_greeting'               => 'Hello {{user_name}},',
    'project_invite_request_content'                => 'Congratulations! You have received a new invite on the project “{{project_title}}”.',

    // ============================ Project approved acknowledgement to buyer - for buyer ============ \\ (Done)
    'project_approved'                              => 'Project approved',

    'project_approved_to_buyer_variables'           => '{{user_name}} — To display the user name.<br> {{project_title}} — To display the project title.<br>{{project_link}} — To display the user name.',
    'project_approved_to_buyer_subject'             => 'Project submission',
    'project_approved_to_buyer_greeting'            => 'Hello {{user_name}},',
    'project_approved_to_buyer_content'             => 'Woohoo! Your project “{{project_title}}” has been approved.<br>Please click on the button below to view the project.<br>{{project_link}}',
    // ============================ proposal submit request - for buyer ============ \\ (Doen)
    'proposal_approve_request'                      => 'Submit Proposal',

    'proposal_approve_request_variables'            => '{{user_name}} — To display the user name.<br> {{seller_name}} — To display the seller name <br> {{project_title}} — To display the project title.<br>{{proposal_link}} — To display the proposal link.',
    'proposal_approve_request_subject'              => 'Submit proposal',
    'proposal_approve_request_greeting'             => 'Hello {{user_name}},',
    'proposal_approve_request_content'              => '{{seller_name}} submit a new proposal on "{{project_title}}". <br> Please click on the button below to view the proposal. <br> {{proposal_link}}',

    // ============================ seller complete project contract request to buyer - for buyer ============ \\ (Doen)
        'project_complete_request'                  => 'Project complete contract',

        'project_complete_request_variables'        => '{{user_name}} — To display the user name.<br> {{seller_name}} — To display the seller name <br> {{project_title}} — To display the project title.<br>{{project_activity_link}} To display the project activity url.',
        'project_complete_request_subject'          => 'Submit complete Project request',
        'project_complete_request_greeting'         => 'Hello {{user_name}},',
        'project_complete_request_content'          => '{{seller_name}} submit a complete contract request against the project "{{project_title}}". <br> Please click on the button below to view the project activity. <br> {{project_activity_link}}',
    

    // ============================ seller complete project contract request declined from buyer - for seller ============ \\ (Doen)
    'project_complete_req_declined'                 => 'Project complete request declined ',

    'proj_complete_req_declined_variables'          => '{{user_name}} — To display the user name.<br>{{project_title}} — To display the project title.<br>{{declined_reason}} - To display the decline reason.<br>{{project_activity_link}} — To display the project activity url.',
    'proj_complete_req_declined_subject'            => 'Declined complete project request',
    'proj_complete_req_declined_greeting'           => 'Hello {{user_name}},',
    'proj_complete_req_declined_content'            => 'Your submit a complete contract request has been declined against the project "{{project_title}}".<br>{{declined_reason}}<br> Please click on the button below to view the project activity.<br>{{project_activity_link}}',
    

    // ============================ Milestone project complete from buyer - for seller ============ \\ (Doen)
    'milestone_project_complete'                   => 'Milestone project contract complete ',

    'milestone_project_comp_var'                   => '{{user_name}} — To display the user name.<br>{{project_title}} - To display the decline reason.<br>{{project_activity_link}} — To display the project activity url.',
    'milestone_project_comp_subj'                  => 'Milestone project contract complete',
    'milestone_project_comp_greeting'              => 'Hello {{user_name}},',
    'milestone_project_comp_cont'                  => 'The project {{project_title}} has been completed.<br>{{project_activity_link}}',
    
    // ============================ seller complete project contract request accepter from buyer - for seller ============ \\ (Doen)
    'project_complete_request_accepted'             => 'Project complete request approved',

    'proj_comp_req_accept_var'                      => '{{user_name}} — To display the user name.<br>{{project_title}} — To display the project title.<br>{{project_activity_link}} To display the project activity url.',
    'proj_comp_req_accept_sub'                      => 'Complete project request approved',
    'proj_comp_req_accept_greeting'                 => 'Hello {{user_name}},',
    'proj_comp_req_accept_cont'                     => 'Your submit a complete contract request has been approved against the project "{{project_title}}". <br> Please click on the button below to view the project activity. <br> {{project_activity_link}}',

    // ============================ proposal submit request declined from buyer  - for seller ============ \\ (Done)
    'proposal_request_declined'                     => 'Submit proposal declined',

    'proposal_request_declined_variables'           => '{{user_name}} — To display the user name.<br> {{project_title}} — To display the project title.<br>{{decline_reason}} To display declined reason.',
    'proposal_request_declined_subject'             => 'Submit proposal declined',
    'proposal_request_declined_greeting'            => 'Hello {{user_name}},',
    'proposal_request_declined_content'             => 'Oho! Your submit proposal has been declined against the project "{{project_title}}"<br>{{decline_reason}}',

    // ============================ proposal submit accpeted from buyer  - for seller ============ \\ (done)
    'proposal_request_accepted'                     => 'Submit proposal accepted', 

    'proposal_request_accepted_variables'           => '{{user_name}} — To display the user name.<br> {{project_title}} — To display the project title.<br>{{project_activity_link}} To display the project activity.',
    'proposal_request_accepted_subject'             => 'Submit proposal accepted',
    'proposal_request_accepted_greeting'            => 'Hello {{user_name}},',
    'proposal_request_accepted_content'             => 'Woohoo! Your submit proposal against “{{project_title}}” has been accepted.<br>Please click on the button below to view the project activity.<br>{{project_activity_link}}',


    // ============================ proposal milestone approval request from seller - for buyer ============ \\ (done)
    'milestone_approve_request'                     => 'Milestone approval request',
    'milestone_approve_request_variables'           => '{{user_name}} — To display the user name.<br> {{milestone_title}} — To display the milestine title. <br> {{project_title}} — To display the project title.<br> {{seller_name}} — To display the seller name <br> {{project_activity_link}} To display the project activity.',
    'milestone_approve_request_subject'             => 'Milestone approval request',
    'milestone_approve_request_greeting'            => 'Hello {{user_name}},',
    'milestone_approve_request_content'             => 'A new milestone “{{milestone_title}}” of project “{{project_title}}” approval received from “{{seller_name}}” <br>Please click on the button below to view the milestone.<br>{{project_activity_link}}',
    // ============================ proposal milestone approval request declined from buyer - for seller ============ \\ (Done)
    'milestone_declined'                            => 'Submit milestone rejected',
    
    'milestone_declined_variables'                  => '{{user_name}} — To display the user name.<br> {{milestone_title}} — To display the milestine title. <br> {{project_title}} — To display the project title.<br>{{project_activity_link}} To display the project activity.',
    'milestone_declined_subject'                    => 'Submit milestone rejected',
    'milestone_declined_greeting'                   => 'Hello {{user_name}},',
    'milestone_declined_content'                    => 'Oho! Your submit milestone “{{milestone_title}}” of “{{project_title}}” has been declined.<br>Please click on the button below to view the milestone.<br>{{project_activity_link}}',
    // ============================ proposal milestone approval request accepted from buyer - for seller ============ \\
    'milestone_accepted'                            => 'Submit milestone accepted',
    
    'milestone_accepted_variables'                  => '{{user_name}} — To display the user name.<br> {{milestone_title}} — To display the milestine title. <br> {{project_title}} — To display the project title.<br>{{project_activity_link}} To display the project activity.',
    'milestone_accepted_subject'                    => 'Submit milestone accepted',
    'milestone_accepted_greeting'                   => 'Hello {{user_name}},',
    'milestone_accepted_content'                    => 'Woohoo! Your submit milestone “{{milestone_title}}” against “{{project_title}}” has been approved.<br>Please click on the button below to view the milestone.<br>{{project_activity_link}}',

     // ============================ proposal milestone escrow from buyer - for seller ============ \\
     'escrow_milestone'                             => 'Milestone escrow',
    
     'escrow_milestone_variables'                  => '{{user_name}} — To display the user name.<br>{{milestone_title}} — To display the milestine title. <br>{{project_title}} — To display the project title.<br>{{project_activity_link}} To display the project activity.',
     'escrow_milestone_subject'                    => 'Submit milestone escrowed',
     'escrow_milestone_greeting'                   => 'Hello {{user_name}},',
     'escrow_milestone_content'                    => 'Milestone “{{milestone_title}}” against the project “{{project_title}}” has been escrowed.<br>Please click on the button below to view the milestone.<br>{{project_activity_link}}',

     
    // ============================ proposal timecard submit request to buyer - for buyer ============ \\
    'timecard_approval_request'                     => 'Submit timecard approval request',
    
    'timecard_approval_request_variables'           => '{{user_name}} — To display the user name.<br> {{timecard_title}} — To display the timecard title. <br> {{project_title}} — To display the project title.<br> {{project_activity_link}} — To display the project activity.<br>{{seller_name}} — To display the seller name',
    'timecard_approval_request_subject'             => 'A new timecard approval request',
    'timecard_approval_request_greeting'            => 'Hello {{user_name}},',
    'timecard_approval_request_content'             => 'A new timecard “{{timecard_title}}” of project “{{project_title}}” approval received from “{{seller_name}}” <br>Please click on the button below to view the timecard detail.<br>{{project_activity_link}}',
    // ============================ proposal timecard approval request declined from buyer - for seller ============ \\ (Done)
      'timecard_declined'                           => 'Submit timecard declined',
    
      'timecard_declined_variables'                 => '{{user_name}} — To display the user name.<br> {{timecard_title}} — To display the timecard title. <br> {{project_title}} — To display the project title.<br>{{decline_reason}} — To display the timecard declined reason. <br> {{project_activity_link}} To display the project activity.',
      'timecard_declined_subject'                   => 'Submit timecard declined',
      'timecard_declined_greeting'                  => 'Hello {{user_name}},',
      'timecard_declined_content'                   => 'Oho! Your submit timecard “{{timecard_title}}” of project “{{project_title}}” has been declined.<br>{{decline_reason}}<br>Please click on the button below to view the timecard detail.<br>{{project_activity_link}}',
    // ============================ proposal timecard approval request accepted from buyer - for seller ============ \\
    'timecard_accepted'                             => 'Submit timecard accepted',
    
    'timecard_accepted_variables'                   => '{{user_name}} — To display the user name.<br> {{timecard_title}} — To display the timecard title. <br> {{project_title}} — To display the project title. {{project_activity_link}} To display the project activity.',
    'timecard_accepted_subject'                     => 'Submit timecard accepted',
    'timecard_accepted_greeting'                    => 'Hello {{user_name}},',
    'timecard_accepted_content'                     => 'Woohoo! Your submit timecard “{{timecard_title}}” against the project “{{project_title}}” has been accepted.<br>Please click on the button below to view the timecard detail.<br>{{project_activity_link}}',

    // ============================ send question to admin - for admin ============ \\
    'send_qeustion'                                 => 'Send question',
    
    'send_qeustion_variables'                       => '{{user_name}} — To display the user name.<br> {{user_email}} — To display the user email. <br> {{question_title}} — To display the question title.<br> {{description}} To display the question description.<br>{{login_url}} To display login button.',
    'send_qeustion_subject'                         => 'You have received a question',
    'send_qeustion_greeting'                        => 'Hello,',
    'send_qeustion_content'                         => '{{user_name}} asked a question/support with the following details mentioned below. <br> Name: {{user_name}} <br> Email: {{user_email}}<br>Topic Title:<br>{{question_title}}<br>Description:<br>{{description}}<br>Please login with the below link to view the details.<br>{{login_url}}',

    // ============================ post gig order - for seller ============ \\ done
    'post_gig_order'                                => 'Post a new order',

    'post_gig_order_variables'                      => '{{user_name}} — To display the seller name.<br> {{gig_title}} — To display the gig title.',
    'post_gig_order_subject'                        => 'A new gig order',
    'post_gig_order_greeting'                       => 'Hello {{user_name}},',
    'post_gig_order_content'                        => 'You have received a new order for the gig “{{gig_title}}”',
    
    'buyer_publish_order_variables'                 => '{{user_name}} — To display the buyer name.',
    'buyer_publish_order_subject'                   => 'New order',
    'buyer_publish_order_greeting'                  => 'Hello {{user_name}},',
    'buyer_publish_order_content'                   => 'Thank you so much for ordering my gig. I will get in touch with you shortly',

    // ============================ Order Complete request - for buyer ============ \\ done
    'seller_order_complete'                         => 'Order Complete request',
    
    'seller_order_complete_variables'               => '{{user_name}} — To display the buyer name.<br>{{seller_name}} — To display the seller name.<br>{{order_id}} — To display the order sequence number.<br>{{login_url}} — To display the login url.<br>{{activity_link}} — To display the login url',
    'seller_order_complete_subject'                 => 'Order complete request',
    'seller_order_complete_greeting'                => 'Hello {{user_name}},',
    'seller_order_complete_content'                 => 'The seller “{{seller_name}}” has sent you the final delivery for the order #{{order_id}}<br>You can accept or decline this. Please login to the site {{login_url}} and take a quick action on this activity {{activity_link}}',
    // ============================ Order Complete delcined request - for seller ============ \\ done
    'order_declined'                                => 'Order complete request declined',
    
    'order_declined_variables'                      => '{{user_name}} — To display the seller name.<br>{{buyer_name}} — To display the buyer name.<br>{{order_id}} — To display the order sequence number.<br>{{buyer_comments}} — To display the buyer comments.',
    'order_declined_subject'                        => 'Order completed request declined',
    'order_declined_greeting'                       => 'Hello {{user_name}},',
    'order_declined_content'                        => 'The buyer “{{buyer_name}}” has declined the final revision and has left some comments against the order #{{order_id}}<br>{{buyer_comments}}<br>',
// ============================ Order Completed - for seller ============ \\ dpne
'order_completed'                                   => 'Order completed',
    
'order_completed_variables'                         => '{{user_name}} — To display the seller name.<br>{{buyer_name}} — To display the buyer name.<br>{{order_id}} — To display the order sequence number.<br>{{buyer_comments}} — To display the buyer comments.,{{buyer_rating}} — To display the buyer rating.',
'order_completed_subject'                           => 'Order completed',
'order_completed_greeting'                          => 'Hello {{user_name}},',
'order_completed_content'                           => 'Congratulations!<br>The buyer “{{buyer_name}}” has closed the ongoing gig with the order #{{order_id}} and has left some comments<br>{{buyer_comments}}<br>{{buyer_rating}}<br>',

// ============================ Order Activity - for seller & buyer ============ \\ done
'order_activity'                                    => 'Order activity',
    
'buyer_order_activity_variables'                    => '{{user_name}} — To display the receiver name.<br>{{sender_name}} — To display the sender name.<br>{{gig_title}} — To display the gig title.<br>{{order_id}} — To display the order sequence number.<br>{{sender_comments}} — To display the sender comments.<br>{{login_url}} — To display the login url.',
'buyer_order_activity_subject'                      => 'Order activity',
'buyer_order_activity_greeting'                     => 'Hello {{user_name}},',
'buyer_order_activity_content'                      => 'You have received a note from the “{{sender_name}}” on the ongoing gig “{{gig_title}}” against the order #{{order_id}}<br>{{sender_comments}}<br>You can login to take a quick action.<br>{{login_url}}',

'seller_order_activity_variables'                   => '{{user_name}} — To display the receiver name.<br>{{sender_name}} — To display the sender name.<br>{{gig_title}} — To display the gig title.<br>{{order_id}} — To display the order sequence number.<br>{{sender_comments}} — To display the sender comments.<br>{{login_url}} — To display the login url.',
'seller_order_activity_subject'                     => 'Order activity',
'seller_order_activity_greeting'                    => 'Hello {{user_name}},',
'seller_order_activity_content'                     => 'You have received a note from the “{{sender_name}}” on the ongoing gig “{{gig_title}}” against the order #{{order_id}}<br>{{sender_comments}}<br>You can login to take a quick action.<br>{{login_url}}',

// ============================New order refund - for seller & admin ============ \\ done
'order_refund_request'                              => 'Order refund request',
    
'seller_received_order_dispute_variables'           => '{{user_name}} — To display the seller name.<br>{{buyer_name}} — To display the buyer name.<br>{{order_id}} — To display the order sequence number.<br>{{buyer_comments}} — To display the sender comments.,{{login_url}} — To display the login url.',
'seller_received_order_dispute_subject'             => 'A new refund request received',
'seller_received_order_dispute_greeting'            => 'Hello {{user_name}},',
'seller_received_order_dispute_content'             => "You've received a refund request from {{buyer_name}} against the order #{{order_id}}<br>{{buyer_comments}}<br>You can approve or decline the refund request.<br>{{login_url}}<br>",

'admin_received_order_dispute_variables'            => '{{order_id}} — To display the gig order sequence number.',
'admin_received_order_dispute_subject'              => 'A new dispute received',
'admin_received_order_dispute_greeting'             => 'Hello',
'admin_received_order_dispute_content'              => "A new dispute has been created against the order #{{order_id}}<br>",

// ============================ Refund comment - for buyer & seller ============ \\ done
'order_refund_reply'                                => 'Order refund comments',

'buyer_order_refund_reply_variables'                => '{{user_name}} — To display the receiver name.<br>{{sender_name}} — To display the sender name.<br>{{order_id}} — To display the order sequence number.<br>{{sender_comments}} — To display the sender comments.<br>{{login_url}} — To display the login url.',
'buyer_order_refund_reply_subject'                  => 'A new comment on refund request',
'buyer_order_refund_reply_greeting'                 => 'Hello {{user_name}},',
'buyer_order_refund_reply_content'                  => "The “{{sender_name}}” has left some comments on the refund request against the order #{{order_id}}<br>{{sender_comments}}<br>{{login_url}}<br>",

'seller_order_refund_reply_variables'               => '{{user_name}} — To display the receiver name.<br>{{sender_name}} — To display the sender name.<br>{{order_id}} — To display the order sequence number.<br>{{sender_comments}} — To display the sender comments.<br>{{login_url}} — To display the login url.',
'seller_order_refund_reply_subject'                 => 'A new comment on refund request',
'seller_order_refund_reply_greeting'                => 'Hello {{user_name}},',
'seller_order_refund_reply_content'                 => "The “{{sender_name}}” has left some comments on the refund request against the order #{{order_id}}<br>{{sender_comments}}<br>{{login_url}}<br>",

// ============================ Dispute order resolved from seller - for buyer ============ \\ done
'seller_appr_order_dispute_req'                     => 'Order refund approved by seller',

'seller_appr_order_dispute_req_variables'           => '{{user_name}} — To display the user name. <br> {{sender_name}} — To display the seller name.<br> {{gig_title}} — To display the gig title.',
'seller_appr_order_dispute_req_subject'             => 'Refund approved',
'seller_appr_order_dispute_req_greeting'            => 'Hello {{user_name}},',
'seller_appr_order_dispute_req_content'             => "Congratulations! <br> Your refund request has been approved by the {{sender_name}} against the gig “{{gig_title}}”",

// ============================ When order dispute declined by seller to buyer - for buyer ============ \\ (Done)
'seller_decline_dispute_order'                      => 'Order refund declined from seller',

'seller_decline_dispute_order_variables'            => '{{user_name}} — To display the user name.<br> {{sender_name}} — To display the sender name.<br> {{gig_title}} — To display the gig title. <br/> {{login_url}} — User Login URL',
'seller_decline_dispute_order_subject'              => 'Refund declined',
'seller_decline_dispute_order_greeting'             => 'Hello {{user_name}}',
'seller_decline_dispute_order_content'              => "Your refund request has been declined by the {{sender_name}} against the gig “{{gig_title}}” <br> If you think that this was a valid request then you can raise a dispute from the ongoing gig order activity page. <br> {{login_url}}",


// ============================ Gig order dispute refunded by admin to winner  ============ \\ (Done)
'admin_refund_order_dispute_to_winner'              => 'Gig order dispute in winner favour',
    
'disp_order_fvr_in_seller_var'                      => '{{user_name}} — To display the seller name.',
'disp_order_fvr_in_seller_sub'                      => 'Dispute resolved',
'disp_order_fvr_in_seller_greeting'                 => 'Hello {{user_name}},',
'disp_order_fvr_in_seller_cont'                     => "Congratulations! <br>We have gone through the refund and dispute and resolved the dispute in your favor. We disputed the gig order and the amount has been added to your account.",

'disp_order_fvr_in_buyer_var'                       => '{{user_name}} — To display the seller name.',
'disp_order_fvr_in_buyer_sub'                       => 'Dispute resolved',
'disp_order_fvr_in_buyer_greeting'                  => 'Hello {{user_name}},',
'disp_order_fvr_in_buyer_cont'                      => "Congratulations! <br>We have gone through the refund and dispute and resolved the dispute in your favor. We disputed the gig order and the amount has been added to your account.",

// ============================ Gig order dispute refunded by admin to not in favour  ============ \\ (Done)
'admin_order_dispute_not_in_favour'                 => 'Gig order dispute not in favour',

'disp_order_not_in_fvr_seller_var'                  => '{{user_name}} — To display the buyer name. <br> {{dispute_link}} — Dispute URL Link',
'disp_order_not_in_fvr_seller_sub'                  => 'Dispute resolved',
'disp_order_not_in_fvr_seller_greeting'             => 'Hello {{user_name}},',
'disp_order_not_in_fvr_seller_cont'                 => "Oho! We did not approve the dispute refund request in your favor.<br>Please click on the button below to view the dispute details.<br>{{dispute_link}}",

'disp_order_not_in_fvr_buyer_var'                   => '{{user_name}} — To display the buyer name. <br> {{dispute_link}} — Dispute URL Link',
'disp_order_not_in_fvr_buyer_sub'                   => 'Dispute resolved',
'disp_order_not_in_fvr_buyer_greeting'              => 'Hello {{user_name}},',
'disp_order_not_in_fvr_buyer_cont'                  => "Oho! We did not approve the dispute refund request in your favor.<br>Please click on the button below to view the dispute details.<br>{{dispute_link}}",

];
