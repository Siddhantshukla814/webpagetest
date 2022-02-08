<?php

declare(strict_types=1);

require_once(__DIR__ . '/../common.inc');

use Respect\Validation\Rules;
use Respect\Validation\Exceptions\NestedValidationException;

use WebPageTest\Template;
use WebPageTest\Util;
use WebPageTest\ValidatorPatterns;
use WebPageTest\Exception\ClientException;
use WebPageTest\RequestContext;

(function(RequestContext $request_context){

if (!Util::getSetting('cp_auth')) {
    $protocol = $request_context->getUrlProtocol();
    $host = Util::getSetting('host');
    $route = '/';
    $redirect_uri = "{$protocol}://{$host}{$route}";

    header("Location: {$redirect_uri}");
    exit();
}

$access_token = $request_context->getUser()->getAccessToken();
if (is_null($access_token)) {
    $protocol = $request_context->getUrlProtocol();
    $host = Util::getSetting('host');
    $route = '/login';
    $redirect_uri = "{$protocol}://{$host}{$route}?redirect_uri={$protocol}://{$host}/account";

    header("Location: {$redirect_uri}");
    exit();
}

$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'POST') {
    $csrf_token = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING);
    if ($csrf_token !== $_SESSION['csrf_token']) {
        throw new ClientException("Invalid CSRF Token");
    }

    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);

    if ($type == 'contact_info') {
        $contact_info_validator = new Rules\AllOf(
            new Rules\Regex('/' . ValidatorPatterns::$contact_info . '/'),
            new Rules\Length(0, 32)
        );

        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $first_name = filter_input(INPUT_POST, 'first-name');
        $last_name = filter_input(INPUT_POST, 'last-name');
        $company_name = filter_input(INPUT_POST, 'company-name');

        try {
            $contact_info_validator->assert($first_name);
            $contact_info_validator->assert($last_name);
            $contact_info_validator->assert($company_name);
        } catch (NestedValidationException $e) {
            $message = $e->getMessages([
                'regex' => 'input cannot contain <, >, or &#'
            ]);
            throw new ClientException(implode(', ', $message));
        }

        $email = $request_context->getUser()->getEmail();

        $options = array(
        'email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'company_name' => $company_name
        );

        try {
            $results = $request_context->getClient()->updateUserContactInfo($id, $options);
            $protocol = $request_context->getUrlProtocol();
            $host = Util::getSetting('host');
            $route = '/account';
            $redirect_uri = "{$protocol}://{$host}{$route}";

            header("Location: {$redirect_uri}");
            exit();
        } catch (Exception $e) {
            throw new ClientException("Could not update user info", "/account", 400);
        }
    } elseif ($type == 'password') {
        $password_validator = new Rules\AllOf(
            new Rules\Length(8, 32)
        );

        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $current_password = filter_input(INPUT_POST, 'current-password');
        $new_password = filter_input(INPUT_POST, 'new-password');
        $confirm_new_password = filter_input(INPUT_POST, 'confirm-new-password');

        try {
          $password_validator->assert($new_password);
          $password_validator->assert($confirm_new_password);
        } catch (Exception $e) {
          throw new ClientException("The requirements are at least 8 characters, including a number, lowercase letter, uppercase letter and symbol. No <, >.", "/account", 400);
        }

        if ($new_password !== $confirm_new_password) {
          throw new ClientException("New Password must match confirmed password", "/account", 400);
        }

        try {
          $request_context->getClient()->changePassword($new_password, $current_password);
          $protocol = $request_context->getUrlProtocol();
          $host = Util::getSetting('host');
          $route = '/account';
          $redirect_uri = "{$protocol}://{$host}{$route}";

          header("Location: {$redirect_uri}");
          exit();
        } catch (Exception $e) {
          throw new ClientException($e->getMessage(), "/account", 400);
        }

    }
} elseif ($request_method == 'GET') {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(35));
    $error_message = $_SESSION['client-error'] ?? null;

    $is_paid = $request_context->getUser()->isPaid();
    $user_contact_info = $request_context->getClient()->getUserContactInfo($request_context->getUser()->getUserId());

    $contact_info = array(
    'layout_theme' => 'b',
    'is_paid' => $is_paid,
    'first_name' => htmlspecialchars($user_contact_info['firstName']),
    'last_name' => htmlspecialchars($user_contact_info['lastName']),
    'email' => $request_context->getUser()->getEmail(),
    'company_name' => htmlspecialchars($user_contact_info['companyName']),
    'id' => $request_context->getUser()->getUserId()
    );

    // TODO - make the call for paid user data
    $billing_info = array();

    if (!$is_paid) {
        $billing_info = array(
        'plan' => '1,000 runs',
        'remaining' => '998',
        'run_renewal' => '12/16/2021',
        'price' => '$180',
        'payment_frequency' => 'Annually',
        'plan_renewal' => '11/17/2022',
        'status' => 'active',
        'cc_number' => '370844******3579',
        'cc_expiration_date' => '11/2042',
        'billing_history' => array(
            array(
            'date_time_stamp' => 'Nov 17 2021 15:39:23',
            'credit_card' => 'AMEX',
            'cc_number' => '370844******3579',
            'amount' => '$180'
            ),
            array(
            'date_time_stamp' => 'Nov 17 2020 15:39:23',
            'credit_card' => 'AMEX',
            'cc_number' => '370844******3579',
            'amount' => '$180'
            )
        )
        );
    } else {
        $info = $request_context->getClient()->getUnpaidAccountpageInfo();
        $plans = $info['wptPlans'];
        $annual_plans = array();
        $monthly_plans = array();
        usort($plans, function ($a, $b) {
            if ($a['price'] == $b['price']) {
                return 0;
            }
            return ($a['price'] < $b['price']) ? -1 : 1;
        });
        foreach ($plans as $plan) {
            if ($plan['billingFrequency'] == 1) {
                $monthly_plans[] = $plan;
            } else {
                $plan['monthly_price'] = $plan['price'] / 12.00;
                $annual_plans[] = $plan;
            }
        }
            $billing_info = array(
            'braintree_client_token' => $info['braintreeClientToken'],
            'annual_plans' => $annual_plans,
            'monthly_plans' => $monthly_plans
            );
    }

    $results = array_merge($contact_info, $billing_info);
    $results['csrf_token'] = $_SESSION['csrf_token'];
    $results['validation_pattern'] = ValidatorPatterns::$contact_info;
    if (!is_null($error_message)) {
      $results['error_message'] = $error_message;
      unset($_SESSION['client-error']);
    }

    $tpl = new Template('account');
    echo $tpl->render('my-account', $results);
    exit();
}
})($request_context);
