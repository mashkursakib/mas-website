# mas-website — MAS Consultancy (masconsultancy.org)

MAS Group official website. Editorial theme, PHP + JSON content store, with a
login-protected admin panel. Deployed on Render (service `mas-website`):
every push to `main` auto-deploys.

## Admin panel

Open **https://masconsultancy.org/admin/**

- Default login: `admin` / `changeme123` — change it immediately in
  Site Settings → Change admin password.
- **Blog Posts** — add, edit, delete posts. They appear on the blog page and
  the three newest show on the homepage.
- **Site Settings** — hero text, the four stats, the about badge, and all
  contact details (one edit updates them everywhere, including the enquiry
  inbox for the contact form).

## Free-plan caveat (important)

This service runs on Render's Free plan, whose filesystem is ephemeral:
anything the admin panel writes (`data/site.json`, `data/posts.json`,
`config.php` password changes, `subscribers.txt`) is lost on the next
redeploy, restart, or spin-down. Treat panel edits as live-but-temporary.
Durable content changes should be committed to `data/site.json` and
`data/posts.json` in this repo instead. Upgrading the service to Starter
with a persistent disk would make panel edits permanent.

## Files

```
index.php           Homepage (reads data/site.json + data/posts.json)
blog.php            News & blog listing
css/style.css       Editorial theme styles
js/main.js          Interactions (counters, tabs, FAQ, filters, forms)
logo.png            Logo (root — referenced as /logo.png)
contact.php         Contact form handler (recipient from Site Settings)
newsletter.php      Newsletter handler (saves subscribers.txt + emails office)
config.php          Admin login (username + password hash) — never share
includes/           Shared PHP helpers (data, auth, CSRF, escaping)
data/               Editable content — site.json (settings), posts.json (blog)
admin/              Control panel (login, dashboard, posts, settings)
Dockerfile          PHP 8.2 + Apache image for Render
.dockerignore       Keeps .git out of the image
robots.txt          Search engine rules (admin + data excluded)
sitemap.xml         Sitemap for Google/Bing
.htaccess           Redirects + access protection (needs AllowOverride All)
```

## Known TODO

- **Contact form email:** PHP `mail()` has no mail server inside the Docker
  image, so form submissions currently fail to send. Wire `contact.php` /
  `newsletter.php` to SMTP (e.g. Spacemail) to make enquiries arrive.
