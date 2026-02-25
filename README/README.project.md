# Laravel presentations

Goal: build a backend interface to create a presentation using markdown

## Quicklinks

- repo: https://github.com/ScriptJayT/Laravel-Presentations

### Docs

- Vue JS: https://vuejs.org/guide/introduction.html
    - icons: https://lucide.dev/icons/
- Laravel: https://laravel.com/docs/12.x
    - md parser: https://commonmark.thephpleague.com/2.x/basic-usage/
    - testing: https://docs.phpunit.de/en/
    - debugbar: https://laraveldebugbar.com/usage/

### Help-out

- Laravel-Vue:
    - Vue import/export from index.ts file: https://stackoverflow.com/questions/74950533/how-to-import-index-vue-files-without-specifying-the-file-name-using-vue-3-and-v
    - select columns in eager loaded models: https://stackoverflow.com/questions/32727060/select-specific-columns-from-eloquent-relations
    - load columns in hasMany models: https://laraveldaily.com/post/laravel-hasmany-load-only-certain-fields-but-dont-skip-xxxxx-id
    - append attributes (readable by Vue): https://5balloons.info/how-to-append-new-attributes-to-eloquent-model/
    - flash messages (in Vue): https://arifhassan.com/flash-messages-in-vue-laravel-app/
    - redirect "back" on login
        - https://laravel.com/docs/12.x/session
        - https://reniki.com/blog/redirect-back-previous-page-after-login-laravel-fortify
        - https://laracasts.com/discuss/channels/laravel/fortify-redirect
- "new" HTML / CSS:
    - anchor position:
        - https://developer.mozilla.org/en-US/docs/Web/CSS/Guides/Anchor_positioning
        - https://www.oddbird.net/2025/01/29/anchor-position-validity/
    - command attributes: https://developer.chrome.com/blog/command-and-commandfor
    - relative colors: https://developer.mozilla.org/en-US/docs/Web/CSS/Reference/Values/color_value/hsl
    - stylable select: https://developer.mozilla.org/en-US/docs/Learn_web_development/Extensions/Forms/Customizable_select

## Project Requirements

- Laravel (Backend app + SSR frontend)
    - User Auth
    - PHP MardDown converter
- Vue JS (Frontend slides)
- ? Three JS (3D Animations)

### App structure

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

### DB structure

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