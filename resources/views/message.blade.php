<p>You received a message from {{ $email ?? '' }}!</p>
<p>Name: {{ $name ?? '' }}</p>
<p>Subject: {{ $subject ?? '(No subject)' }}</p>
<p>Message: {{ $body ?? '' }}</p>
<p>---</p>
<p>Note: this is an automated alert. Please make sure you are replying to {{ $email }}, not subtle.noreply@gmail.com – or your reply won't be received.</p>
