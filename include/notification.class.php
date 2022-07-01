<?php
	include("class.phpmailer.php");
	class Notification extends Functions
	{
		private $mailer2;
		
		public function sendEmail($toemail,$subject="",$body="") // Common Email Function
	    {
	    	
			$from_name =SITENAME;
			$from_mail =SITEMAIL;
			$this->mailer2 = new PHPMailer();
			$this->mailer2->SetFrom($from_mail,$from_name); // From email ID and from name
			$this->mailer2->AddAddress($toemail);
			$this->mailer2->Subject = $subject;
			$this->mailer2->MsgHTML($body);
			//echo "<pre>";print_r($this->mailer2);exit;
			$this->mailer2->Send();
	    }
		public function sendEmail2($toemail,$email,$subject="",$body="") // Common Email Function
	    {
	    	
			$from_name =SITENAME;
			$from_mail =SITEMAIL;
			$this->mailer2 = new PHPMailer();
			$this->mailer2->SetFrom($from_mail); // From email ID and from name
			$this->mailer2->AddAddress($toemail,$email);
			$this->mailer2->Subject = $subject;
			$this->mailer2->MsgHTML($body);
			//echo "<pre>";print_r($this->mailer2);exit;
			$this->mailer2->Send();
	    }
		
		public function sendEmailAttachment($toemail,$subject="",$body="",$attch = "") // Common Email Function
	    {
	    	
			$from_name = SITENAME;
			$from_mail = SITEMAIL;
			$this->mailer2 = new PHPMailer();
			$this->mailer2->SetFrom($from_mail,$from_name); // From email ID and from name
			$this->mailer2->AddAddress($toemail);
			$this->mailer2->Subject = $subject;
			$this->mailer2->MsgHTML($body);
			$this->mailer2->addAttachment($attch);
			//$this->mailer2->AddCC($dis_cc);
			//echo "<pre>";print_r($this->mailer2);exit;
			$this->mailer2->Send();
	    }
	};
?>