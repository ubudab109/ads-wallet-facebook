<?php

function UserStatus($input = null) {
  $output = [
    USER_STATUS_NON_ACTIVE => __('Not Active'),
    USER_STATUS_ACTIVE => __('Active'),
    USER_STATUS_RESTRICTED => __('Restricted'), 
  ];

  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}


function FormReviewStatus($input = null) {
  $output = [
    FORM_REVIEW_NOT_APPLICANT => __('Anda Belum Submit Form'),
    FORM_REVIEW_PENDING => __('Pending'),
    FORM_REVIEW_ACCEPTED => __('Accepted'),
    FORM_REVIEW_REJECTED => __('Rejected'),
    FORM_REVIEW_WAITING_LIST => __('WAITING LIST'),
  ];

  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}

function TopupStatus($input = null) {
  $output = [
    TOPUP_PENDING => __('Pending'),
    TOPUP_APPROVED => __('Approved'),
    TOPUP_REJECTED => __('Rejected'),
  ];

  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}


function CostSpend($input = null) {
  $output = [
    COST_SPENDING_0 => __('0 Juta - 60 Juta'),
    COST_SPENDING_1 => __('50 Juta - 100 Juta'),
    COST_SPENDING_2 => __('100 Juta - 500 Juta'),
    COST_SPENDING_3 => __('500 Juta - 1 M'),
    COST_SPENDING_4 => __('>1m'),
  ];

  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}

function IconUserStatus($input = null) {
  $output = [
    USER_STATUS_ACTIVE => 'user-check',
    USER_STATUS_NON_ACTIVE => 'user-minus',
    USER_STATUS_RESTRICTED => 'user-x',
  ];
  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}

function FontThemeUserStatus($input = null) {
  $output = [
    USER_STATUS_ACTIVE => 'text-theme-9',
    USER_STATUS_NON_ACTIVE => 'text-theme-6',
    USER_STATUS_RESTRICTED => 'text-theme-11',
  ];
  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}

function AccountType($input = null) {
  $output = [
    ACCOUNT_TELEGRAM  => __('Telegram'),
    ACCOUNT_WHATSAPP  => __('Whatsapp'),
  ];

  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}

function FormStatusClass($input = null) {
  $output = [
    FORM_REVIEW_NOT_APPLICANT  => 'text-2xl text-gray-700 dark:text-gray-600 font-medium leading-none',
    FORM_REVIEW_PENDING => 'text-2xl text-theme-12 font-medium leading-none',
    FORM_REVIEW_ACCEPTED => 'text-2xl text-theme-9 font-medium leading-none',
    FORM_REVIEW_REJECTED => 'text-2xl text-theme-6 font-medium leading-none',
    FORM_REVIEW_WAITING_LIST => 'text-2xl text-theme-1 font-medium leading-none',
  ];

  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}

function RefundUserStatus($input = null) {
  $output = [
    REFUND_USER_PENDING => __("Pending"),
    REFUND_USER_APPROVED => __("Approved"),
    REFUND_USER_REJECTED => __("Rejected"),
  ];

  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}

function RefundUserBadget($input = null) {
  $output = [
    REFUND_USER_PENDING => "text-2xl text-theme-12 font-medium leading-none",
    REFUND_USER_APPROVED => "text-2xl text-theme-9 font-medium leading-none",
    REFUND_USER_REJECTED => "text-2xl text-theme-6 font-medium leading-none",
  ];

  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}

function TicketStatus($input = null) {
  $output = [
    STATUS_TICKET_PENDING => __("PENDING"),
    STATUS_TICKET_IN_PROGRESS => __("IN PROGRESS"),
    STATUS_TICKET_FINISHED => __("SELESAI"),
  ];

  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}

function TicketPriority($input = null) {
  $output = [
    TICKET_PRIORITY_LOW => __("LOW"),
    TICKET_PRIORITY_MEDIUM => _("MEDIUM"),
    TICKET_PRIORITY_HIGH => __("HIGH"),
  ];

  if (is_null($input)) {
    return $output;
  } else {
    return $output[$input];
  }
}