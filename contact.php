<?php
    include("header.php");

    if(isset($_POST['sub'])){
        include('con.php');
        $uid     = $_SESSION['user']['u_id'];
        $fname   = mysqli_real_escape_string($con, $_POST['fname']);
        $email   = mysqli_real_escape_string($con, $_POST['email']);
        $subject = mysqli_real_escape_string($con, $_POST['subject']);
        $txt     = mysqli_real_escape_string($con, $_POST['txt']);

        $add   = "INSERT INTO feedback(u_id,f_name,f_email,f_subject,f_txt) VALUES ('$uid','$fname','$email','$subject','$txt')";
        $query = mysqli_query($con, $add);
        $contact_success = $query;
    }
?>

<!-- Inner Page Head -->
<section class="inner_page_head">
   <h3>Contact Us</h3>
</section>

<!-- Contact Section -->
<section class="why_section layout_padding">
   <div class="container">

      <?php if (isset($contact_success)): ?>
      <div style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#22c55e;padding:14px 20px;border-radius:10px;margin-bottom:28px;text-align:center;max-width:700px;margin-left:auto;margin-right:auto">
         ✓ Your message has been sent! We'll get back to you soon.
      </div>
      <?php endif; ?>

      <div class="row">
         <div class="col-lg-6 offset-lg-3">

            <!-- Contact Info Strip -->
            <div style="display:flex;gap:20px;flex-wrap:wrap;justify-content:center;margin-bottom:40px">
               <div style="background:var(--card);border:1px solid var(--border);border-radius:12px;padding:18px 24px;text-align:center;flex:1;min-width:140px">
                  <div style="font-size:1.4rem;margin-bottom:6px">📍</div>
                  <div style="font-size:0.78rem;color:var(--gold);letter-spacing:1px;text-transform:uppercase;margin-bottom:4px">Location</div>
                  <div style="font-size:0.85rem;color:var(--text)">New York, USA</div>
               </div>
               <div style="background:var(--card);border:1px solid var(--border);border-radius:12px;padding:18px 24px;text-align:center;flex:1;min-width:140px">
                  <div style="font-size:1.4rem;margin-bottom:6px">📞</div>
                  <div style="font-size:0.78rem;color:var(--gold);letter-spacing:1px;text-transform:uppercase;margin-bottom:4px">Phone</div>
                  <div style="font-size:0.85rem;color:var(--text)">+91 987 654 3210</div>
               </div>
               <div style="background:var(--card);border:1px solid var(--border);border-radius:12px;padding:18px 24px;text-align:center;flex:1;min-width:140px">
                  <div style="font-size:1.4rem;margin-bottom:6px">✉</div>
                  <div style="font-size:0.78rem;color:var(--gold);letter-spacing:1px;text-transform:uppercase;margin-bottom:4px">Email</div>
                  <div style="font-size:0.85rem;color:var(--text)">mirecal@info.com</div>
               </div>
            </div>

            <div class="full" style="background:var(--card);border:1px solid var(--border);border-radius:16px;padding:36px">
               <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.8rem;color:var(--cream);margin-bottom:6px">Send a Message</h3>
               <p style="color:var(--text-dim);font-size:0.88rem;margin-bottom:28px">We'd love to hear from you.</p>
               <form method="post">
                  <fieldset>
                     <input type="text" placeholder="Your full name" name="fname" required />
                     <input type="email" placeholder="Your email address" name="email" required />
                     <input type="text" placeholder="Subject" name="subject" required />
                     <textarea placeholder="Write your message here..." name="txt" required rows="5"></textarea>
                     <input type="submit" value="Send Message" name="sub"/>
                  </fieldset>
               </form>
            </div>

         </div>
      </div>
   </div>
</section>

<?php include("footer.php"); ?>