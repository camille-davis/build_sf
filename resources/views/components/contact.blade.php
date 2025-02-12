<form method="POST" action="/contact" id="contact-form">
@csrf

    <input name="name" type="text" placeholder="Name" maxlength="205" autocomplete="name">
    <input name="email" type="email" placeholder="Email" maxlength="205" required autocomplete="email">
    <input name="subject" type="text" maxlength="205" placeholder="Subject">
    <textarea name="body" maxlength="10000" placeholder="Message" required></textarea>

    @if (config('services.recaptcha.key'))
        <div style="margin: auto;" class="g-recaptcha"
            data-sitekey="{{ config('services.recaptcha.key') }}">
        </div>
        <script>
            addCaptchaError(document.getElementById('contact-form'));
        </script>
    @endif

    <button type="submit">Send</button>

</form>
