# Laravel presentations

Goal: build a backend interface to create a presentation using markdown

## Framework Requirements

- Laravel (Backend app + SSR frontend)
    - User Auth
    - PHP MardDown converter
- Vue JS (Frontend slides)
- ? Three JS (3D Animations)

## Project structure

- Admin panel
    - Login/Logout
    - Presentation overview
    - New Presentation
        - edit Presentation
            - title
            - visibility {public, logged-in, creator}
            - slides
            - full script
            - theme
            - ? injecting custom js elements / iframes
        - Slide previews
        - new Slide / edit Slide
            - title
            - content
            - images
            - theme
            - layout
- Health
- Frontend
    - visible presentations - show title + theme thumbnail
    - presentation
- ? JSON API Presentation
    - both markdown as html
    - fullscript, slides or both

## DB structure

- presentations
    - id, timestamps
    - title                     VARCHAR
    - creator                   INT FOREIGN Key `users`
    - full_script               INT FOREIGN Key `presentation_scripts`          NULLABLE
    - visibility                INT FOREIGN Key `presentation_visibility`
    - default_theme             INT FOREIGN Key `presentation_themes`
- presentation_slides
    - id, timestamps
    - presentation              INT FOREIGN Key `presentations`
    - title                     VARCHAR                                         NULLABLE
    - content                   LONGTEXT
    - order                     INT
    - theme                     INT FOREIGN Key `presentation_scripts`          NULLABLE
- presentation_scripts
    - id, timestamps
    - title                     VARCHAR
    - content                   LONGTEXT                                        NULLABLE
- presentation_themes
    - id, timestamps
    - title                     VARCHAR
- presentation_visibility
    - id, timestamps
    - title                     VARCHAR