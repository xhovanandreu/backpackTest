<h1>Hello {{ $classroom->teacher->full_name ?? 'Teacher' }},</h1>

<p>You have been assigned to a new classroom: <strong>{{ $classroom->name }}</strong>.</p>

<p>Capacity: {{ $classroom->capacity }}</p>
<p>Start Date: {{ $classroom->start_date }}</p>

<p>Thank you,<br>School Management System</p>
