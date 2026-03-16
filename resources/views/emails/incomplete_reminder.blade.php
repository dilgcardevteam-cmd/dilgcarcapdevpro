<!DOCTYPE html>
<html>
<head>
    <title>Incomplete Activity Reminder</title>
</head>
<body>
    <p>Hello {{ $participant->name }},</p>
    <p>This is a reminder regarding your progress in the course: <strong>{{ $course->name }}</strong>.</p>
    <p>The following activities are still incomplete:</p>
    <ul>
        @foreach ($incompleteActivities as $activity)
            <li>{{ $activity->title }} – Not Completed</li>
        @endforeach
    </ul>
    <p>Please log in to the platform to continue your course.</p>
    <p><a href="{{ route('trainer.courses.enter', $course) }}">Go to Course</a></p>
    <p>This is an automated reminder.</p>
</body>
</html>