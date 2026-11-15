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
index.php           Homepage: hero, stats, firm + service teasers, Why MAS, news
about.php           About the group: story, mission & vision, firm tabs, how we work
services.php        All seven service lines + challenges switcher + how to start
e-procurement.php   MAS Corporation deep dive: process, portals, contracts, sectors
web-it.php          MAS Communication deep dive: what we build + typical journey
market-entry.php    MAS Consultancy deep dive: the six-step setup journey
portfolio.php       Selected engagements (anonymised), firm by firm
faq.php             Frequently asked questions
contact-us.php      Contact page (info cards + form + map)
blog.php            News & blog listing
post.php            Single article page
css/style.css       Editorial theme styles
js/main.js          Interactions (counters, tabs, FAQ, filters, forms)
logo.png            Logo (root — referenced as /logo.png)
contact.php         Contact form handler (recipient from Site Settings)
newsletter.php      Newsletter handler (saves subscribers.txt + emails office)
config.php          Admin login (username + password hash) — never share
includes/           Shared PHP: helpers (functions.php) + page layout (layout.php)
data/               Editable content — site.json (settings), posts.json (blog)
admin/              Control panel (login, dashboard, posts, settings)
Dockerfile          PHP 8.2 + Apache image for Render
.dockerignore       Keeps .git out of the image
robots.txt          Search engine rules (admin + data excluded)
sitemap.xml         Sitemap for Google/Bing
.htaccess           Redirects + access protection (needs AllowOverride All)
```

## Email setup (Resend)

Render blocks outbound SMTP (ports 465 and 587 both time out from the
service), so the contact and newsletter forms send through the Resend
HTTPS API (`includes/mailer.php`, no dependencies). Set this environment
variable on the Render service (Dashboard → mas-website → Environment).
Never commit the key — this repo is public.

```
RESEND_API_KEY=re_...   (from resend.com/api-keys)
RESEND_FROM=MAS Website <info@masconsultancy.org>   (optional; this is the default)
```

Before sending works, verify masconsultancy.org in Resend (Domains → Add
Domain) and add the DNS records it shows (SPF/DKIM) at Spaceship — if an
SPF record already exists, merge Resend's include into it instead of
adding a second one. The free plan covers 3,000 emails/month, max
100/day. If the API key is missing or sending fails, the contact form
shows an error to the visitor (and logs it); newsletter signups are
still saved to `subscribers.txt`.
