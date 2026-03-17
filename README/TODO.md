## Today:

- write script
- ? Add a visually interesting bg to index

### Done:

- Improve db-queries for app index, app slideshow
- Dark mode does not set color-scheme (scrollbars don't switch with)
- App index columns breaking on smaller screens

## Global:

- [ ] make press bout project
- [ ] finish project before 20/03
- vacature "Functioneel Analyst"
    - [x] 10/03: check on status
        - check mailbox
        - send reminder mail for updates
    - [ ] 18/03: check on status
- vacature "Jr JS Mobile Developer"
    - [ ] 20/03 check on status
        - app.wiggli
        - chack mailbox
        - send reminder mail for updates

## Project:

- Init
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
- App Functions
    - [~] CRUD operations:
        - [ ] ? Add an atom lock to all operations
        - [x] Add presentations
        - [~] Add slides
            - [ ] ? Add media/scripts injecting (custom elements, iframes)
            - [ ] ? Add full bg options
        - [x] Add scripts
        - [~] ? Add users
            - [ ] Add avatar option
            - [ ] Add roles
            - [x] Cleanup "unreachable" user actions
        - [ ] ? Add themes
        - [ ] ? Add a media manager
    - Guarding:
        - [x] Throw error 403 w/ redirect if not allowed
        - [x] Make private models also private from other users
        - [x] ? Make scripts/presentations/slides private-able
    - [~] Markdown:
        - [~] Allow download of:
            - [x] Content of scripts
            - [ ] ? Whole presentation
        - [~] Allow upload in:
            - [x] Scripts
            - [ ] ? Presentations
            - [ ] ? Slides
    - Slideshow:
        - [x] Add fullscreen mode
    - [ ] ? Add a read-only API
        - Type: json
        - [ ] Allow content rendering of md/html
        - [ ] Allow selection of script/slides/both
- App Look
    - [x] Find better (temp) logo for app
    - [x] Cleanup app darkmode
    - [x] Add appname logo to app header
    - [x] ? Add icons icons of User, Protected, Private to index
    - [ ] ? Add a visually interesting bg to index
- Bugs:
    - [ ] Dashboard app icon squishes when closing sidebar
    - [x] Create user initial function can't handle emoji's
    - [x] App index columns breaking on smaller screens
    - [x] Dark mode does not set color-scheme (scrollbars don't switch with)
- Extra's
    - [x] Improve db-queries for app index, app slideshow
    - [x] Add a check health route to dashboard
    - [ ] ? Add password rotation in queue for bot users
- Test:
    - [x] Add extra temp user to seeder to manually test private scripts/presentations
    - Presentation CRUD:
        - [x] can store a new entry
        - [x] can read when public public/protected & random user
        - [x] can't read when private & random user
        - [x] can update when public public/protected & (random) user
        - [x] can't update when private & random user
        - [x] can delete when public/protected & (random) user
        - [x] can't delete when private & random user
    - Script CRUD:
        - [x] can store a new entry
        - [x] can read when public public/protected & random user
        - [x] can't read when private & random user
        - [x] can update when public public/protected & (random) user
        - [x] can't update when private & random user
        - [x] can delete when public/protected & (random) user
        - [x] can't delete when private & random user
    - Slides CRUD:
        - [x] can store a new entry
        - [x] can update when public public/protected & (random) user
        - [x] can't update when private & random user
        - [x] can delete when public/protected & (random) user
        - [x] can't delete when private & random user
