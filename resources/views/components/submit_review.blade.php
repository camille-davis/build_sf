<div class="sheet">
    <div id="submit-review">
        <h2>Leave a Review</h2>
        <form method="POST" action="/review" id="review">
        @csrf
            <input name="name" type="text" placeholder="Your name" maxlength="205" required>
            <textarea name="review" maxlength="10000" placeholder="Your review" required></textarea>

            @if (config('services.recaptcha.key'))
                <div style="margin: auto;" class="g-recaptcha"
                    data-sitekey="{{ config('services.recaptcha.key') }}">
                </div>
            @endif

            </script>

            <button type="submit">Send</button>

        </form>
    </div>
</div>
