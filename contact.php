<?php
    include("header.php");
    include('con.php');
 
   
      if(isset($_POST['sub'])){
         $uid = $_SESSION['user']['u_id'];
         $fname = $_POST['fname'];
         $email = $_POST['email'];
         $subject = $_POST['subject'];
         $txt = $_POST['txt'];

         $add = "INSERT INTO feedback(u_id,f_name,f_email,f_subject,f_txt) VALUES ('$uid','$fname','$email','$subject','$txt')";
         $quey = mysqli_query($con,$add);
         if($quey){
            echo "<script>alert('Good Job!!')</script>";
         }
         else{
            echo "<script>alert('Some error')</script>";
         }
      }
    
?>
      <!-- inner page section -->
      <section class="inner_page_head">
         <div class="container_fuild">
            <div class="row">
               <div class="col-md-12">
                  <div class="full">
                     <h3>Contact us</h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- end inner page section -->
      <!-- why section -->
      <section class="why_section layout_padding">
         <div class="container">
         
            <div class="row">
               <div class="col-lg-8 offset-lg-2">
                  <div class="full">
                     <form method="post">
                        <fieldset>
                           <input type="text" placeholder="Enter your full name" name="fname" required />
                           <input type="email" placeholder="Enter your email address" name="email" required />
                           <input type="text" placeholder="Enter subject" name="subject" required />
                           <textarea placeholder="Enter your message" name="txt" required ></textarea>
                           <input type="submit" value="Submit" name="sub"/>
                        </fieldset>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- end why section -->
<?php
    include("footer.php");
?>