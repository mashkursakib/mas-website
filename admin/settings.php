<?php
// MAS Admin — site settings (hero, stats, contact) + password change.
require_once __DIR__ . '/../includes/functions.php';
require_login();

$site = load_site();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        $error = 'Session expired — please try again.';
    } elseif (($_POST['form'] ?? '') === 'password') {
        $current = $_POST['current_password'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        if (!password_verify($current, ADMIN_PASS_HASH)) {
            $error = 'Current password is wrong.';
        } elseif (strlen($newPass) < 8) {
            $error = 'New password must be at least 8 characters.';
        } elseif ($newPass !== $confirm) {
            $error = 'New passwords do not match.';
        } else {
            $configPath = SITE_ROOT . '/config.php';
            $contents = @file_get_contents($configPath);
            $oldLine = "define('ADMIN_PASS_HASH', '" . ADMIN_PASS_HASH . "');";
            $newLine = "define('ADMIN_PASS_HASH', '" . password_hash($newPass, PASSWORD_DEFAULT) . "');";
            if ($contents === false || substr_count($contents, $oldLine) !== 1) {
                $error = 'Could not update config.php — check file permissions.';
            } elseif (@file_put_contents($configPath, str_replace($oldLine, $newLine, $contents), LOCK_EX) === false) {
                $error = 'Could not write config.php — check file permissions.';
            } else {
                flash('Password changed. Use the new password next time you log in.');
                redirect('settings.php');
            }
        }
    } elseif (($_POST['form'] ?? '') === 'settings') {
        $meta = [];
        for ($i = 0; $i < 3; $i++) {
            $meta[] = [
                'value' => trim($_POST['meta_value'][$i] ?? ''),
                'label' => trim($_POST['meta_label'][$i] ?? ''),
            ];
        }
        $stats = [];
        for ($i = 0; $i < 4; $i++) {
            $stats[] = [
                'value'  => max(0, (int) ($_POST['stat_value'][$i] ?? 0)),
                'suffix' => trim($_POST['stat_suffix'][$i] ?? ''),
                'label'  => trim($_POST['stat_label'][$i] ?? ''),
            ];
        }
        $new = [
            'hero' => [
                'badge'      => trim($_POST['hero_badge'] ?? ''),
                'title'      => trim($_POST['hero_title'] ?? ''),
                'accent'     => trim($_POST['hero_accent'] ?? ''),
                'subtitle'   => strip_tags(trim($_POST['hero_subtitle'] ?? ''), '<strong><em><br><a>'),
                'chip_value' => trim($_POST['chip_value'] ?? ''),
                'chip_text'  => trim($_POST['chip_text'] ?? ''),
                'meta'       => $meta,
            ],
            'stats' => $stats,
            'about' => [
                'badge_year' => trim($_POST['about_year'] ?? ''),
                'badge_text' => trim($_POST['about_text'] ?? ''),
            ],
            'contact' => [
                'address'       => trim($_POST['address'] ?? ''),
                'phone_display' => trim($_POST['phone_display'] ?? ''),
                'phone_tel'     => trim($_POST['phone_tel'] ?? ''),
                'whatsapp'      => preg_replace('/\D+/', '', $_POST['whatsapp'] ?? ''),
                'email1'        => trim($_POST['email1'] ?? ''),
                'email2'        => trim($_POST['email2'] ?? ''),
                'hours'         => trim($_POST['hours'] ?? ''),
            ],
            'site' => [
                'name'     => $site['site']['name'] ?? 'MAS Consultancy',
                'email_to' => trim($_POST['email_to'] ?? ''),
            ],
        ];
        $email1 = $new['contact']['email1'];
        $emailTo = $new['site']['email_to'];
        if ($new['hero']['title'] === '') {
            $error = 'Hero title cannot be empty.';
        } elseif ($email1 !== '' && !filter_var($email1, FILTER_VALIDATE_EMAIL)) {
            $error = 'Main email is not a valid email address.';
        } elseif ($emailTo !== '' && !filter_var($emailTo, FILTER_VALIDATE_EMAIL)) {
            $error = 'Enquiry inbox is not a valid email address.';
        } elseif (!save_site($new)) {
            $error = 'Could not save — check that data/site.json is writable.';
        } else {
            flash('Settings saved. The live site updates immediately.');
            redirect('settings.php');
        }
        $site = $new; // keep submitted values in the form on error
    }
}

$pageTitle = 'Site Settings';
$active = 'settings';
require_once __DIR__ . '/_header.php';

$hero = $site['hero'] ?? [];
$stats = $site['stats'] ?? [];
$about = $site['about'] ?? [];
$contact = $site['contact'] ?? [];
$siteMeta = $site['site'] ?? [];
?>

<h1>Site Settings</h1>
<p class="lede">Everything here updates the live site immediately — no code changes needed.</p>

<?php if ($error): ?>
  <div class="alert alert-error"><?php echo e($error); ?></div>
<?php endif; ?>

<form method="post" action="settings.php">
  <?php echo csrf_field(); ?>
  <input type="hidden" name="form" value="settings">

  <div class="card">
    <h2>Hero (top of homepage)</h2>
    <div class="field">
      <label for="hero_badge">Badge text</label>
      <input type="text" id="hero_badge" name="hero_badge" value="<?php echo e($hero['badge'] ?? ''); ?>">
    </div>
    <div class="field-grid">
      <div class="field">
        <label for="hero_title">Headline</label>
        <input type="text" id="hero_title" name="hero_title" value="<?php echo e($hero['title'] ?? ''); ?>">
      </div>
      <div class="field">
        <label for="hero_accent">Headline accent (italic gold words)</label>
        <input type="text" id="hero_accent" name="hero_accent" value="<?php echo e($hero['accent'] ?? ''); ?>">
      </div>
    </div>
    <div class="field">
      <label for="hero_subtitle">Subheadline</label>
      <textarea id="hero_subtitle" name="hero_subtitle"><?php echo e($hero['subtitle'] ?? ''); ?></textarea>
      <span class="hint">You can use &lt;strong&gt; around words to make them bold.</span>
    </div>
    <div class="field-grid">
      <div class="field">
        <label for="chip_value">Photo chip — big number</label>
        <input type="text" id="chip_value" name="chip_value" value="<?php echo e($hero['chip_value'] ?? ''); ?>">
      </div>
      <div class="field">
        <label for="chip_text">Photo chip — text (one line per row)</label>
        <textarea id="chip_text" name="chip_text" style="min-height: 60px;"><?php echo e($hero['chip_text'] ?? ''); ?></textarea>
      </div>
    </div>
    <fieldset>
      <legend>Facts strip under the headline</legend>
      <?php for ($i = 0; $i < 3; $i++): ?>
      <div class="field-grid">
        <div class="field">
          <label>Fact <?php echo $i + 1; ?> — value</label>
          <input type="text" name="meta_value[<?php echo $i; ?>]" value="<?php echo e($hero['meta'][$i]['value'] ?? ''); ?>">
        </div>
        <div class="field">
          <label>Fact <?php echo $i + 1; ?> — label</label>
          <input type="text" name="meta_label[<?php echo $i; ?>]" value="<?php echo e($hero['meta'][$i]['label'] ?? ''); ?>">
        </div>
      </div>
      <?php endfor; ?>
    </fieldset>
  </div>

  <div class="card">
    <h2>Stats band (animated counters)</h2>
    <?php for ($i = 0; $i < 4; $i++): ?>
    <fieldset>
      <legend>Stat <?php echo $i + 1; ?></legend>
      <div class="field-grid-3">
        <div class="field">
          <label>Number</label>
          <input type="number" name="stat_value[<?php echo $i; ?>]" value="<?php echo (int) ($stats[$i]['value'] ?? 0); ?>" min="0">
        </div>
        <div class="field">
          <label>Suffix (%, +, or empty)</label>
          <input type="text" name="stat_suffix[<?php echo $i; ?>]" value="<?php echo e($stats[$i]['suffix'] ?? ''); ?>" maxlength="3">
        </div>
        <div class="field">
          <label>Label</label>
          <input type="text" name="stat_label[<?php echo $i; ?>]" value="<?php echo e($stats[$i]['label'] ?? ''); ?>">
        </div>
      </div>
    </fieldset>
    <?php endfor; ?>
  </div>

  <div class="card">
    <h2>About badge</h2>
    <div class="field-grid">
      <div class="field">
        <label for="about_year">Year</label>
        <input type="text" id="about_year" name="about_year" value="<?php echo e($about['badge_year'] ?? ''); ?>">
      </div>
      <div class="field">
        <label for="about_text">Badge text (one line per row)</label>
        <textarea id="about_text" name="about_text" style="min-height: 60px;"><?php echo e($about['badge_text'] ?? ''); ?></textarea>
      </div>
    </div>
  </div>

  <div class="card">
    <h2>Contact details (used everywhere: contact section, footer, menus)</h2>
    <div class="field">
      <label for="address">Office address (one line per row)</label>
      <textarea id="address" name="address"><?php echo e($contact['address'] ?? ''); ?></textarea>
    </div>
    <div class="field-grid">
      <div class="field">
        <label for="phone_display">Phone (as shown)</label>
        <input type="text" id="phone_display" name="phone_display" value="<?php echo e($contact['phone_display'] ?? ''); ?>" placeholder="+880 1913 876636">
      </div>
      <div class="field">
        <label for="phone_tel">Phone (for tap-to-call links)</label>
        <input type="text" id="phone_tel" name="phone_tel" value="<?php echo e($contact['phone_tel'] ?? ''); ?>" placeholder="+8801913876636">
      </div>
    </div>
    <div class="field">
      <label for="whatsapp">WhatsApp number (digits only, with country code)</label>
      <input type="text" id="whatsapp" name="whatsapp" value="<?php echo e($contact['whatsapp'] ?? ''); ?>" placeholder="8801913876636">
      <span class="hint">Used by the WhatsApp button and chat links.</span>
    </div>
    <div class="field-grid">
      <div class="field">
        <label for="email1">Main email</label>
        <input type="email" id="email1" name="email1" value="<?php echo e($contact['email1'] ?? ''); ?>">
      </div>
      <div class="field">
        <label for="email2">Second email</label>
        <input type="email" id="email2" name="email2" value="<?php echo e($contact['email2'] ?? ''); ?>">
      </div>
    </div>
    <div class="field">
      <label for="hours">Business hours (one line per row)</label>
      <textarea id="hours" name="hours"><?php echo e($contact['hours'] ?? ''); ?></textarea>
    </div>
    <div class="field">
      <label for="email_to">Enquiry inbox (where contact-form messages go)</label>
      <input type="email" id="email_to" name="email_to" value="<?php echo e($siteMeta['email_to'] ?? ''); ?>">
    </div>
  </div>

  <div class="btn-row" style="margin-top: 0;">
    <button type="submit" class="btn">Save settings</button>
    <a class="btn btn-outline" href="../index.php" target="_blank" rel="noopener">View live site ↗</a>
  </div>
</form>

<div class="card" id="password" style="margin-top: 28px;">
  <h2>Change admin password</h2>
  <form method="post" action="settings.php#password">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="form" value="password">
    <div class="field">
      <label for="current_password">Current password</label>
      <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
    </div>
    <div class="field-grid">
      <div class="field">
        <label for="new_password">New password (min 8 characters)</label>
        <input type="password" id="new_password" name="new_password" required autocomplete="new-password">
      </div>
      <div class="field">
        <label for="confirm_password">Confirm new password</label>
        <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password">
      </div>
    </div>
    <button type="submit" class="btn">Change password</button>
  </form>
  <?php /* Temporary: shows the current password hash so the repo can be synced after a password change. Remove once the repo config.php matches. */ ?>
  <p class="hint" style="margin-top: 14px;">Current password hash (for syncing the site code after a change): <code><?php echo e(ADMIN_PASS_HASH); ?></code></p>
</div>

<?php require_once __DIR__ . '/_footer.php'; ?>
