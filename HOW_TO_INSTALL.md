# Thank you for downloading Phoenix theme! <3

## Installation

1. Make sure you have the theme set to "default" in your controlpanel's settings.
2. Copy all files from `copy-from-me` to the root folder in controlpanel folder, it should be in `/var/www/controlpanel`. Make sure to turn on Overwrite files and merge folders when copying!
3. You have to correct the permissions, to do that, follow [the controlpanel's docs](https://ctrlpanel.gg/docs/Installation/getting-started#set-permissions).
4. Run `php artisan optimize:clear` to clear the cache.

- If you use cloudflare, you will have to purge the cache of javascript file, follow these steps to do so:
  - Go to your website in cloudflare dashboard
  - In the right sidebar, click on **Purge Cache** -> **Custom Purge**
  - Add `https://your-dashboard-domain/js/app.js` in the text input.
  - It might take a few seconds for the purge to complete, now Continue step 5.

5. Hard refresh the page by `Ctrl + Shift + R`.

And you are done! The theme should be installed now!

## Troubleshoot

If you are having any issue while installing this theme, feel free to contact me on discord: `@flamekitten`, Or you can join My discord server [Flame Develops](https://discord.gg/wyh77B3x9v)
