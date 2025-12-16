<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Helpers\Session;
use App\Models\ContactModel;

class ContactController extends Controller
{
    //contact page
    public function contact()
    {
        Auth::requireRole([0,3]);
        $message = '';
        $errors = [];
        if (isset($_POST['submit'])) {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);

            if (empty($name) || !preg_match("/^[A-Za-z ]{3,50}$/", $name)) {
                $errors[] = "Name must be 3–50 characters and contain only letters & spaces.";
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Please enter a valid email address.";
            }
            if (empty($subject) || strlen($subject) < 3) {
                $errors[] = "Subject must be at least 3 characters.";
            }
            if (empty($message) || strlen($message) < 10) {
                $errors[] = "Message must be at least 10 characters.";
            }
            if (empty($errors)) {
                $userid = Session::get('user_id');
                $contactModel = new ContactModel();
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message,
                ];
                if ($contactModel->sendquery($userid, $data)) {
                    $message = "Message Sent Successfully";
                } else {
                    $errors[] = "Something Wrong While sending query";
                }
            }

        }
        $this->view('/employee/contactsupport',[
            'message'=>$message,
            'error'=>$errors,
        ]);
    }
}
