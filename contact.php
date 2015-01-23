        <?php
          $name = $_POST['your_name'];
          $email = $_POST['your_email'];
          $message = $_POST['your_message'];
          $from = 'From: MyWebsite'; 
          $to = 'progressive_o@yahoo.com'; 
          $subject = 'Hello';
          $human = $_POST['human'];
			
          $body = ("From: $name\n E-Mail: $email\n Message:\n $message");
				
          if ($_POST['contact_submitted'] && $human == '4') {				 
          if (mail ($to, $subject, $body, $from)) { 
      	    print ('<p>Your message has been sent!</p>');
          } else { 
	          echo '<p>Something went wrong, go back and try again!</p>'; 
          } 
          } if ($_POST['contact_submitted'] && $human != '4') {
          	echo '<p>You answered the anti-spam question incorrectly!</p>';
          }
        ?>
