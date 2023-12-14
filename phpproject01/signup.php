<?php include_once 'header.php'; ?>

<section class="index-intro" style="text-align: center;">
    <h2 style="font-size: 36px;">Sign Up</h2>
    
    <form action="includes/signup.inc.php" method="post" class="centered-form" style="display: inline-block; text-align: left; max-width: 500px; margin: auto;">
        <input type="text" name="name" placeholder="Full Name" class="input-large" style="width: 100%; font-size: 16px; padding: 10px;"> <br><br>
        <input type="email" name="email" placeholder="Email" class="input-large" style="width: 100%; font-size: 16px; padding: 10px;"> <br><br>
        <input type="text" name="uid" placeholder="Username" class="input-large" style="width: 100%; font-size: 16px; padding: 10px;"> <br><br>
        <input type="password" name="pwd" placeholder="Password" class="input-large" style="width: 100%; font-size: 16px; padding: 10px;"> <br><br>
        <input type="password" name="pwdrepeat" placeholder="Repeat Password" class="input-large" style="width: 100%; font-size: 16px; padding: 10px;"> <br><br>
        <input type="number" name="apartment_id" placeholder="Apartment ID" class="input-large" style="width: 100%; font-size: 16px; padding: 10px;"> <br><br>
        
        <button type="submit" name="submit" class="btn-signup" style="display: block; margin: auto; font-size: 16px; padding: 10px 20px;">Submit</button>
    </form>
</section>

<?php include_once 'footer.php'; ?>
