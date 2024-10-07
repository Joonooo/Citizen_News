<div class="container my-5">
    <h2>Contact Me</h2>
    <p>If you have any questions or want to collaborate, feel free to reach out to me:</p>
    <ul>
        <li>Email: <a href="mailto:seonjunwoo@gmail.com">seonjunwoo@gmail.com</a></li>
        <li>GitHub: <a href="https://github.com/Joonooo" target="_blank">github.com/Joonooo</a></li>
    </ul>

    <!-- Contact Form (optional) -->
    <h4>Contact Form:</h4>
    <form action="/send-message" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>
