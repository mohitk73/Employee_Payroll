<head>
    <link rel="stylesheet" href="../assets/css/contactsupport.css">
</head>
<main>
    <section>
        <h3>Contact Support</h3>
        <div class="contact-form">
            <p style="color: green;"><?= htmlspecialchars($message) ?></p>
              <?php if (!empty($errors)) { ?>
        <div style="color: red; margin-bottom: 15px;">
            <?php foreach ($errors as $err) { ?>
                <p>• <?= $err ?></p>
            <?php } ?>
        </div>
    <?php } ?>
            <h4>Send us a message</h4>
            <form method="POST" action="">
                <label for="name">Your Name:</label><br>
                <input type="text" id="name" name="name" pattern="[A-Za-z ]{3,50}"  required><br><br>
                <label for="email">Your Email:</label><br>
                <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required><br><br>
                <label for="subject">Subject:</label><br>
                <input type="text" id="subject" name="subject" pattern="[A-Za-z0-9 ,.!?'-]{3,100}"  required><br><br>
                <label for="message">Message:</label><br>
                <textarea id="message" name="message" rows="5" minlength="10"
          maxlength="200"required></textarea><br><br>
                <button type="submit" name="submit">Send Message</button>
            </form>
        </div>
        <div class="contact-support">
            <p>If you need any help, then please reach out to our support team:</p>
            <ul>
                <li>Email: admin@mind2web.io</li>
                <li>Phone: +91 7676765645</li>
            </ul>
        </div>
    </section>
    
</main>