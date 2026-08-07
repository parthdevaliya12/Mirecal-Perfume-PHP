<!-- Footer -->
<footer>
   <div class="container">
      <div class="row">
         <!-- Brand Info -->
         <div class="col-md-4 mb-5 mb-md-0">
            <div class="full">
               <div class="logo_footer">
                  <img src="images/logo.jpeg" alt="Mirecal Logo">
               </div>
               <div class="footer-brand-name">Mire<span>cal</span></div>
               <div class="information_f">
                  <p><i class="fa fa-map-marker" style="color:var(--gold);width:16px"></i> 28 White Tower, Street Name, New York City, USA</p>
                  <p><i class="fa fa-phone" style="color:var(--gold);width:16px"></i> +91 987 654 3210</p>
                  <p><i class="fa fa-envelope" style="color:var(--gold);width:16px"></i> mirecal@info.com</p>
               </div>
            </div>
         </div>

         <!-- Menu Links -->
         <div class="col-md-2 mb-5 mb-md-0">
            <div class="widget_menu">
               <h3>Menu</h3>
               <ul>
                  <li><a href="index.php">Home</a></li>
                  <li><a href="about.php">About</a></li>
                  <li><a href="product.php">Products</a></li>
                  <li><a href="contact.php">Contact</a></li>
               </ul>
            </div>
         </div>

         <!-- Account Links -->
         <div class="col-md-2 mb-5 mb-md-0">
            <div class="widget_menu">
               <h3>Account</h3>
               <ul>
                  <li><a href="order.php">My Orders</a></li>
                  <li><a href="cart.php">Cart</a></li>
                  <li><a href="checkout.php">Checkout</a></li>
                  <li><a href="logout.php">Logout</a></li>
               </ul>
            </div>
         </div>

         <!-- Newsletter -->
         <div class="col-md-4">
            <div class="widget_menu">
               <h3>Newsletter</h3>
               <div class="information_f">
                  <p style="color:var(--text-dim)">Subscribe and get exclusive offers & fragrance updates.</p>
               </div>
               <div class="form_sub" style="margin-top:16px">
                  <form>
                     <fieldset style="border:none">
                        <div class="field">
                           <input type="email" placeholder="Enter your email address" name="email" />
                           <input type="submit" value="Subscribe" />
                        </div>
                     </fieldset>
                  </form>
               </div>
            </div>
         </div>

      </div>
   </div>
</footer>

<!-- Copyright -->
<div class="cpy_">
   <p>© 2025 Mirecal Perfumes. All Rights Reserved &nbsp;|&nbsp; Crafted by <span style="color:var(--gold)">Parth Devaliya</span></p>
</div>

<!-- jQuery -->
<script src="js/jquery-3.4.1.min.js"></script>
<!-- Popper JS -->
<script src="js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="js/bootstrap.js"></script>
<!-- Custom JS -->
<script src="js/custom.js"></script>

<!-- Toast Utility -->
<script>
function showToast(msg, type='success') {
   var t = document.createElement('div');
   t.className = 'toast-msg ' + type;
   t.textContent = msg;
   document.body.appendChild(t);
   setTimeout(function(){ t.remove(); }, 3200);
}
</script>

   </body>
</html>