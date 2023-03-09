<?php
interface EmailServerInterface {
	public function sendEmail($to, $name, $subject, $message);
}
?>
