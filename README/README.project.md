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
