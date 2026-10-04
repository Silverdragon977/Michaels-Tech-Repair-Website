<h1>New Website Inquiry</h1>

<p><strong>Name:</strong> {{ $details['name'] }}</p>
<p><strong>Email:</strong> {{ $details['email'] }}</p>
<p><strong>Phone:</strong> {{ $details['phone'] ?: 'Not provided' }}</p>
<p><strong>Service:</strong> {{ $details['service'] }}</p>

<h2>Message</h2>

<p style="white-space: pre-wrap;">{{ $details['message'] }}</p>