- [x] Brainstorm
- [x] Setup
- [x] Design
- [x] Name App
    laravel - presentations - hel
    helltation
    presenthell
    tationhell
    hellpres
    hellpress - empress - hell'press
    hellshow - hellow
    pressy
- [x] Check health route
- [x] make private models also private from other users
- CRUD operations
    - [x] Presentations
    - [x] Slides
    - [x] Scripts
    - [~] ? Users
    - [ ] Guarded actions throw error 405 w/ redirect
    - ? Themes
    - ? Atom lock
- [~] Test
    - [ ] Presentation CRUD
        - can delete when public/protected & (random) user
        - can't delete when private & random user
    - [ ] Script CRUD
        - [x] can read when public public/protected & random user
        - [x] can't read when private & random user
        - [x] can update when public public/protected & (random) user
        - [x] can't update when private & random user
        - [ ] can delete when public/protected & (random) user
        - [ ] can't delete when private & random user
    - [ ] Slides CRUD
        - can update when public public/protected & (random) user
        - can't update when private & random user
        - can delete when public/protected & (random) user
        - can't delete when private & random user
- ? User Roles
- [x] ? Private PresentationScripts
- ? Js Script injecting (custom elements, iframes)
- ? Read-only API
    - json
    - md | html content
    - script | slides | both

## Done today:

- implemented visibility guard
    - public, protected, private
    - prev: show views
    - now: admin protection for private
- tested new implementation
- todo:
    - throw 405 error in implementation
    - check laravel for better guard on select methods, w/ custom redirect & flash message
