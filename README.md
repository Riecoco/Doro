# Doro Pomodoro Productivity App

Doro is a Pomodoro productivity web application built for students who want a simple and aesthetic way to manage study sessions. Users can log in, manage personal tasks, use a customizable Pomodoro timer, and view motivational quotes. Admin users can manage the quote collection shown in the app.

## Implemented Features

### Authentication

* Users can register and log in.
* JWT authentication is used to protect private routes.
* User roles are supported.
* Admin-only functionality is protected through backend role authorization.

### Normal User Features

* View the home page with the Pomodoro timer, task panel, and random quote.
* Create personal tasks using an inline input.
* Edit existing tasks by clicking on the task text.
* Save task edits by clicking away from the input.
* Mark tasks as completed.
* Delete tasks.
* Switch between To Do and Completed task views.
* Change Pomodoro timer settings for focus time, short break, and long break.

### Admin Features

* View (paginated) quotes in the quotes dashboard.
* Add new quotes.
* Edit existing quotes.
* Delete quotes.

## Deferred Features

The original proposal included more personalization and media-related features. To keep the final version stable and realistic for the deadline, the following features were postponed:

* Spotify integration
* Time usage reports
* Subtasks
* Task notes
* Background image customization
* Sound effects when the timer ends

These features may be added in a future version.

## Data Seeder

`developmentdb.sql`

## Test Accounts

```txt
Normal user: amyra
Email: amyra@example.com
Password: password123

Admin user: mia.admin
Email: mia.admin@example.com
Password: password123
```

## AI Disclosure

An AI disclosure statement is included in `AI_DISCLOSURE.md`.

## GitHub Repository

https://github.com/Riecoco/Doro
