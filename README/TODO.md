## Today:

- write script
- make press bout project

### Done:

- Script page md not styled

## Global:

- [ ] make press bout project
- [ ] finish project before 20/03
- vacature "Functioneel Analyst"
    - [x] 10/03: check on status
        - check mailbox
        - send reminder mail for updates
    - [x] 18/03: check on status
    - [ ] 27/03: talk

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
    - Dashboard:
        - [ ] ? allow ctrl+s to quicksave
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
    - [ ] ? Form submit button should be sticky bottom-0
- Bugs:
    - [x] Dashboard app icon squishes when closing sidebar
    - [x] Create user initial function can't handle emoji's
    - [x] App index columns breaking on smaller screens
    - [x] Dark mode does not set color-scheme (scrollbars don't switch with)
    - [x] Edit Script View: `Download as` button misses hover, see Edit Prsentation View `Create a` link
    - [x] Danger zone colors in dark mode too dark
    - [x] Sidezone buttons no hover, see close actionmodal
    - [x] Actionmodal close not rounded
    - [x] Dashboard Slides overview outline wrong color
    - [x] User edit route, should temp become user show route
    - [x] Search no focus visible, no hover
    - [x] Formfield hover/ focus visible
    - [x] App Nav not showing current page
    - [ ] Dashboard active page not showing if sub-page
    - [x] Script page md not styled
- Extra's
    - [x] Improve db-queries for app index, app slideshow
    - [x] Add a check health route to dashboard
    - [ ] ? Add password rotation in queue for bot users
    - [ ] ? MD support for:
        - [x] underline: ` __text__ `
        - [x] small text: ` -# text `
        - [x] spoilers: `||text||`
        - supscript: `lorem^(text)`
        - subpscript: `lorem~(text)`
        - multiline quote: `>>> text \n text \n\n`
    - [ ] ? MD rendering:
        - syntax highlighting in code blocks: ` ```lang `
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
