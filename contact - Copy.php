<?php
    include "connect.php";
    include "include/notification.class.php";

    $name       = '';
    $email      = '';
    $phone_number = '';
    $subject    = '';
    $message    = '';

    if (isset($_REQUEST['contact_submit'])) 
    {
        $name   = $_REQUEST['name'];
        $email  = $_REQUEST['email'];
        $phone_number = $_REQUEST['phone_number'];
        $subject= $_REQUEST['subject'];
        $message= $_REQUEST['message'];

        $contact_arr = array(
            "name"      => $name, 
            "email"     => $email,
            "phone"     => $phone_number,
            "subject"   => $subject,
            "message"   => $message,
        );

        $contact_id = $db->insert("contact",$contact_arr);

        if ( !empty($contact_id) && ISMAIL ) 
        {
            $nt = new Notification();

            // Send main to user
            include("mailbody/contact_form_to_user.php");
            // die($body);
            $toemail = $email;
            $nt->sendEmail($toemail, $subject, $body);

            // Send mail to admin
            include("mailbody/contact_form_to_admin.php");
            // die($body);
            $toemail = SITEMAIL;
            $nt->sendEmail($toemail, $subject, $body);
        }

    }
?>
<!DOCTYPE html>
<html lang="en" class="">
    <head>
        <!-- Site Title -->
        <title>Matthias Grossmann's First Site</title>
        <?php include "front_include/css.php"; ?>
    </head>
    <body>
        <?php include "front_include/header.php"; ?>        
        <!-- page header section start  -->
        <section class="page-header-section contact-hero-image pt-100">
            <div class="container">
                <div class="row">
                    <div class="page-heading-section pt-120 pb-120">
                        <h2>Contact Us</h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- page header section end  -->
        <!-- questions section start -->
        <section class="Questions-section pt-80 pb-80">
            <div class="container">
                <div class="row">
                    <div class="offset-lg-3 col-lg-6">
                        <div class="Questions-sec-content">
                            <h2>Have questions?<br>
                                We'd love to hear from you!
                            </h2>
                            <p>Feel free to send us your inquiry by filling out the form below. We will get back to you as soon as possible. You can also visit our social media channels for news, updates, and more.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- questions section End -->
        <!-- Send message section start -->
        <section class="Send_message-section pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <div class="offset-lg-3 col-lg-6">
                        <div class="section-header text-center mb-4">
                            <h1>Send us a message.</h1>
                            <p>A member of our team will get back to you as soon as possible. </p>
                        </div>
                        <form class="contact-form shadow-none" method="post" name="contact_form" id="contact_form">
                            <div class="form-group">
                                <input class="form-control" type="text" name="name" id="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" id="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="Phone Number">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="subject" id="subject" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <textarea class="custom-textarea" rows="4" name="message" id="message" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn outline-btn" name="contact_submit" id="contact_submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Send message section start -->
        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>  
        <script type="text/javascript">
            $("#contact_form").validate({
                rules:{
                    name: { required:true },
                    email: { required:true, email:true },
                    phone_number: { required:true },
                    subject: { required:true },
                    message: { required:true },
                },
                messages:{
                    name: { required:"Please enter name." },
                    email: { required:"Please enter email address.", email:"Please enter valid email." },
                    phone_number: { required:"Please enter phone number." },
                    subject: { required:"Please subject." },
                    message: { required:"Please enter message." },  
                }  
            });
            
        </script>
    </body>
</html>