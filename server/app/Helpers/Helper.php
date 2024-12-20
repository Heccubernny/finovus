<?php

use App\Models\Settings;
use Illuminate\Support\Facades\Mail;

if(!function_exists('user_ip_address')){
    function user_ip_address(){
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}

if(!function_exists('send_email')){
    function send_email($to, $name, $subject, $message){
        $settings = Settings::first();
        $mail_logo = Logo::first();
        $email = config('app.mail.email');
        $from = config('app.mail.username');
        $site = $settings->site_name;
        $phone = $settings->phone_number;
        $details = $settings->site_description;
        $logo = url('/').'/asset/'.$mail_logo->image_url;
        $data = [
            'email' => $email,
            'from' => $from,
            'site' => $site,
            'phone' => $phone,
            'details' => $details,
            'logo' => $logo,
            'message' => $message
        ];
        // $headers = "From: " . strip_tags('no-reply@'.$_SERVER['HTTP_HOST']) . "\r\n";
        // $headers .= "Reply-To: ". strip_tags('no-reply@'.$_SERVER['HTTP_HOST']) . "\r\n";
        // $headers .= "MIME-Version: 1.0\r\n";
        // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        Mail::send('notifications.emails.mail', $data, function($message) use ($name, $to, $subject, $from, $site){
            $message->to($to, $name)->subject($subject);
            $message->from($from, $site);
        });
    }
}