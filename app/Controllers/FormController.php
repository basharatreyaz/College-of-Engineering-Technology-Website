<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Application;
use App\Models\Enquiry;
use App\Models\Programme;
use App\Services\View;
use App\Services\Session;
use App\Services\MailerService;
use App\Services\RateLimiter;
use RuntimeException;

class FormController
{
    public function apply(): void
    {
        $progModel = new Programme();
        $programmes = $progModel->getActive();

        View::render('pages.apply', [
            'pageTitle' => 'Online Admission Application | KCET Srinagar',
            'metaDescription' => 'Apply online for 4-Year B.Tech and Lateral Entry programmes at Kashmir College of Engineering & Technology.',
            'programmes' => $programmes
        ]);
    }

    public function submitApplication(): void
    {
        // 1. Honeypot spam check
        if (!empty($_POST['website_hp'])) {
            // Silently discard spam bot submission
            redirect('/apply/success?ref=KCET-SPAM-BLOCKED');
        }

        // 2. Rate limit
        RateLimiter::hit('application', 3600);

        // 3. Validation
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $phone = trim($_POST['phone'] ?? '');
        $whatsapp = trim($_POST['whatsapp_number'] ?? '');
        $dob = trim($_POST['dob'] ?? '');
        $gender = trim($_POST['gender'] ?? 'Not Specified');
        $programmeId = (int)($_POST['programme_id'] ?? 0);
        $parentName = trim($_POST['parent_name'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $state = trim($_POST['state'] ?? 'Jammu and Kashmir');
        $pincode = trim($_POST['pincode'] ?? '');
        $priorEducation = trim($_POST['prior_education'] ?? '');
        $marks = trim($_POST['marks_percentage'] ?? '');
        $currentStatus = trim($_POST['current_status'] ?? '');
        $consent = isset($_POST['consent']);

        $errors = [];

        if (empty($firstName) || strlen($firstName) < 2) {
            $errors[] = 'Please enter a valid first name.';
        }
        if (empty($lastName)) {
            $errors[] = 'Please enter your last name.';
        }
        if (!$email) {
            $errors[] = 'Please provide a valid email address.';
        }
        $phoneDigits = preg_replace('/\D/', '', $phone);
        if (empty($phone) || strlen($phoneDigits) < 10) {
            $errors[] = 'Please provide a valid 10-digit contact mobile number.';
        }
        if (empty($parentName)) {
            $errors[] = 'Please provide parent/guardian name.';
        }
        if (empty($address)) {
            $errors[] = 'Please provide your permanent address.';
        }
        if (empty($city)) {
            $errors[] = 'Please enter your city/district.';
        }
        if (empty($pincode)) {
            $errors[] = 'Please enter a valid postal pincode.';
        }
        if (empty($priorEducation)) {
            $errors[] = 'Please specify your prior educational qualification.';
        }
        if (empty($marks)) {
            $errors[] = 'Please specify your marks or percentage obtained.';
        }
        if (!$consent) {
            $errors[] = 'You must confirm that the provided details are true and consent to verification.';
        }

        $progModel = new Programme();
        $programme = $progModel->find($programmeId);
        if (!$programme) {
            $errors[] = 'Please select a valid engineering programme.';
        }

        if (!empty($errors)) {
            Session::setOld($_POST);
            flash('error', implode('<br>', $errors));
            redirect('/apply');
        }

        // 4. Save Application
        $appModel = new Application();
        $refNumber = $appModel->generateApplicationNumber();

        $appId = $appModel->create([
            'application_number' => $refNumber,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'whatsapp_number' => $whatsapp ?: $phone,
            'dob' => !empty($dob) ? $dob : null,
            'gender' => $gender,
            'programme_id' => $programmeId,
            'parent_name' => $parentName,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'pincode' => $pincode,
            'prior_education' => $priorEducation,
            'marks_percentage' => $marks,
            'current_status' => $currentStatus,
            'status' => 'new',
            'notes' => 'Submitted via online admissions portal.',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
        ]);

        // Record history
        try {
            $db = \App\Services\Database::getInstance();
            $db->execute("INSERT INTO application_status_history (application_id, status, remarks) VALUES (:app_id, 'new', 'Application submitted by candidate')", [
                ':app_id' => $appId
            ]);
        } catch (\Throwable) {}

        // Send confirmation email
        $subject = "KCET Admission Application Received - Ref: {$refNumber}";
        $body = "<h2>Kashmir College of Engineering & Technology</h2>"
              . "<p>Dear <strong>{$firstName} {$lastName}</strong>,</p>"
              . "<p>Thank you for submitting your admission application for <strong>{$programme['name']}</strong>.</p>"
              . "<p>Your unique application reference number is: <strong style='font-size:18px; color:#0B2545;'>{$refNumber}</strong>.</p>"
              . "<p>Please keep this reference number for future communication and counselling verification.</p>"
              . "<p>Admissions Office, KCET Srinagar<br>Phone: +91 88994 12793<br>Email: info@kcet.edu.in</p>";
        MailerService::send($email, $subject, $body);

        Session::clearOld();
        Session::set('last_application', [
            'id' => $appId,
            'reference' => $refNumber,
            'name' => "{$firstName} {$lastName}",
            'email' => $email,
            'phone' => $phone,
            'programme' => $programme['name'],
            'degree' => $programme['degree_type']
        ]);

        redirect('/apply/success?ref=' . urlencode($refNumber));
    }

    public function applicationSuccess(): void
    {
        $ref = $_GET['ref'] ?? '';
        $appData = Session::get('last_application');

        if (!$appData && !empty($ref)) {
            $appModel = new Application();
            $app = $appModel->findBy('application_number', $ref);
            if ($app) {
                $progModel = new Programme();
                $prog = $progModel->find((int)$app['programme_id']);
                $appData = [
                    'id' => $app['id'],
                    'reference' => $app['application_number'],
                    'name' => $app['first_name'] . ' ' . $app['last_name'],
                    'email' => $app['email'],
                    'phone' => $app['phone'],
                    'programme' => $prog['name'] ?? 'B.Tech Programme',
                    'degree' => $prog['degree_type'] ?? 'B.Tech'
                ];
            }
        }

        View::render('pages.apply-success', [
            'pageTitle' => 'Application Submitted Successfully | KCET Srinagar',
            'metaDescription' => 'Your admission application has been registered with KCET.',
            'appData' => $appData,
            'ref' => $ref
        ]);
    }

    public function submitEnquiry(): void
    {
        $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ||
                  isset($_GET['ajax']);

        // Honeypot check
        if (!empty($_POST['enquiry_hp'])) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Thank you for your enquiry.']);
                exit;
            }
            flash('success', 'Thank you! Your enquiry has been received.');
            redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }

        RateLimiter::hit('enquiry', 3600);

        $name = trim($_POST['full_name'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $phone = trim($_POST['phone'] ?? '');
        $progId = !empty($_POST['programme_id']) ? (int)$_POST['programme_id'] : null;
        $subject = trim($_POST['subject'] ?? 'General Admission Enquiry');
        $message = trim($_POST['message'] ?? '');
        $source = trim($_POST['source_page'] ?? 'modal');

        $errors = [];
        if (empty($name)) $errors[] = 'Please provide your full name.';
        if (!$email) $errors[] = 'Please provide a valid email address.';
        $digits = preg_replace('/\D/', '', $phone);
        if (empty($phone) || strlen($digits) < 10) $errors[] = 'Please enter a valid 10-digit mobile number.';
        if (empty($message)) {
            $message = 'Prospective student inquiring about admissions, eligibility, and course details for 2026-27.';
        }

        if (!empty($errors)) {
            if ($isAjax) {
                http_response_code(422);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors]);
                exit;
            }
            Session::setOld($_POST);
            flash('error', implode('<br>', $errors));
            redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }

        $enquiryModel = new Enquiry();
        $enquiryModel->create([
            'full_name' => $name,
            'email' => $email,
            'phone' => $phone,
            'programme_id' => $progId,
            'subject' => $subject,
            'message' => $message,
            'source_page' => $source,
            'status' => 'new',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ]);

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Thank you for your enquiry! Our admissions team will reach out to you shortly.']);
            exit;
        }

        Session::clearOld();
        flash('success', 'Thank you for contacting us! Our admissions counsellor will get back to you shortly.');
        redirect($_SERVER['HTTP_REFERER'] ?? '/');
    }

    public function submitContact(): void
    {
        $this->submitEnquiry();
    }
}

