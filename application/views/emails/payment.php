<?php
if (!isset($renovacion)) {
    $renovacion = 0;
}
$isPlanEmail = isset($is_plan) ? (int)$is_plan : 0;
$siteName = 'Dale Más Bajo';
$siteUrl  = 'https://dalemasbajo.com';
$logoUrl  = $siteUrl . '/images/logo.png';
$iconUrl  = $siteUrl . '/images/icon-white.png';
$facebookIcon = $siteUrl . '/images/icons/facebook.png';
$twitterIcon  = $siteUrl . '/images/icons/twitter.png';
$fallbackImage = $siteUrl . '/images/favicon.png';
?>
<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <style>
        .spacer, .divider {mso-line-height-rule: exactly;}
        td,th,div,p,a,h1,h2,h3,h4,h5,h6 {font-size:13px; line-height:23px; font-family:"Segoe UI",Helvetica,Arial,sans-serif;}
    </style>
    <![endif]-->
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:400,700');
        @media only screen {
            .serif {font-family: 'Montserrat', sans-serif!important;}
            .sans-serif {font-family: 'Open Sans', sans-serif!important;}
            .column, th, td, div, p {font-family: -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI","Roboto",Helvetica,Arial,sans-serif;}
        }
        #outlook a {padding: 0;}
        a {text-decoration: none;}
        table {border-collapse: collapse;}
        img {border: 0; display: block; line-height: 100%;}
        .column, th, td, div, p {font-size: 13px; line-height: 23px;}
        .wrapper {min-width: 700px;}
        .row {margin: 0 auto; width: 700px;}
        .row .row, th .row {width: 100%;}
        @media only screen and (max-width: 699px) {
            .wrapper {min-width: 100% !important;}
            .row {width: 90% !important;}
            .row .row {width: 100% !important;}
            .column {
                box-sizing: border-box;
                display: inline-block !important;
                line-height: inherit !important;
                width: 100% !important;
                word-break: break-word;
                -webkit-text-size-adjust: 100%;
            }
            .mobile-4  {max-width: 33.33333%;}
            .mobile-6  {max-width: 50%;}
            .mobile-8  {max-width: 66.66667%;}
            .mobile-12 {
                padding-right: 30px !important;
                padding-left: 30px !important;
            }
            .has-columns {
                padding-right: 20px !important;
                padding-left: 20px !important;
            }
            .has-columns .column {
                padding-right: 10px !important;
                padding-left: 10px !important;
            }
            img {
                width: 100% !important;
                height: auto !important;
            }
            .mobile-center {
                display: table !important;
                float: none;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .mobile-left {
                float: none;
                margin: 0 !important;
            }
            .mobile-text-left   {text-align: left !important;}
            .mobile-valign-top  {vertical-align: top !important;}
            .spacer {height: 30px; line-height: 100% !important; font-size: 100% !important;}
            .divider th {height: 60px;}
            .mobile-padding-bottom {padding-bottom: 30px !important;}
            .mobile-padding-top-mini {padding-top: 10px !important;}
        }
    </style>
</head>
<body style="box-sizing:border-box;margin:0;padding:0;width:100%;-webkit-font-smoothing:antialiased;">

<table class="wrapper" align="center" bgcolor="#EEEEEE" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 30px 0;">

            <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="spacer" height="40">&nbsp;</td>
                </tr>
                <tr>
                    <th class="column" width="640" style="padding-left: 30px; padding-right: 30px; text-align: left;">
                        <a href="<?php echo $siteUrl; ?>" style="text-decoration: none;">
                            <img class="mobile-center" src="<?php echo $logoUrl; ?>" width="105" alt="<?php echo $siteName; ?>" style="border: 0; width: 100%; max-width: 105px;">
                        </a>
                    </th>
                </tr>
                <tr>
                    <td class="spacer" height="40">&nbsp;</td>
                </tr>
            </table>

            <table class="row" align="center" bgcolor="#F8F8F8" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="spacer" height="80">&nbsp;</td>
                </tr>
                <tr>
                    <th class="column has-columns" width="640" style="padding-left: 30px; padding-right: 30px;">
                        <table class="row" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <th class="column" width="640" style="text-align: left;">
                                    <div class="serif" style="color: #1F2225; font-size: 28px; font-weight: 700; line-height: 50px; margin-bottom: 30px;">
                                        Hello <?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?>,
                                    </div>
                                    <div class="sans-serif" style="color: #969AA1; font-size: 18px; font-weight: 400; line-height: 28px; margin-bottom: 40px;">
                                        <?php echo ((int)$renovacion === 1) ? 'Your plan renewal has been confirmed.' : 'Your payment has been confirmed.'; ?>
                                        Here is a summary of your order.
                                    </div>
                                </th>
                            </tr>
                        </table>

                        <table class="row" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <th class="column" width="640" style="padding-right: 10px; color: #969AA1; font-size: 13px; font-weight: 400; text-align: left;">
                                    <div class="sans-serif" style="color: #1F2225; font-size: 17px; margin-bottom: 15px;">Billed to:</div>
                                    <div class="sans-serif" style="font-size: 14px;"><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div class="sans-serif" style="font-size: 14px;">
                                        <strong><?php echo ((int)$renovacion === 1) ? 'Renewal' : 'Order'; ?> #</strong> <?php echo (int)$orden->id; ?>
                                    </div>
                                    <?php if (!empty($orden->txn_id)) { ?>
                                        <div class="sans-serif" style="font-size: 14px;">
                                            <strong>Transaction ID:</strong> <?php echo htmlspecialchars($orden->txn_id, ENT_QUOTES, 'UTF-8'); ?>
                                        </div>
                                    <?php } ?>
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <td class="spacer" height="80">&nbsp;</td>
                </tr>
            </table>

            <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="spacer" height="80">&nbsp;</td>
                </tr>
                <tr>
                    <th class="column" width="640" style="padding-left: 30px; padding-right: 30px; font-weight: 400; text-align: left;">
                        <div class="serif" style="color: #1F2225; font-size: 18px;">Order summary</div>
                    </th>
                </tr>
                <tr>
                    <td class="spacer" height="50">&nbsp;</td>
                </tr>
            </table>

            <?php foreach ($items as $item) { ?>
                <?php if (!$isPlanEmail) { ?>
                    <?php
                    $itemImage = $fallbackImage;
                    if (!empty($item->featured_image)) {
                        $path = ltrim($item->featured_image, '/');
                        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
                            $itemImage = $path;
                        } else {
                            $itemImage = $siteUrl . '/' . $path;
                        }
                    }
                    ?>
                    <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
                        <tr class="mobile-valign-top">
                            <th class="column mobile-4" width="145" style="padding-left: 30px; padding-right: 10px; text-align: left;">
                                <img src="<?php echo $itemImage; ?>" width="100" alt="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8'); ?>" style="border: 0; width: 100%; max-width: 100px;">
                            </th>
                            <th class="column mobile-8" width="255" style="padding-left: 10px; padding-right: 10px; font-weight: 400; text-align: left;">
                                <div class="serif" style="color: #1F2225; font-size: 16px; font-weight: 700; margin-bottom: 10px;">
                                    <?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                                <?php if (!empty($item->artist)) { ?>
                                    <div class="sans-serif" style="color: #969AA1; font-size: 13px; line-height: 20px;">
                                        Artist: <?php echo htmlspecialchars($item->artist, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($item->version)) { ?>
                                    <div class="sans-serif" style="color: #969AA1; font-size: 13px; line-height: 20px;">
                                        Version: <?php echo htmlspecialchars($item->version, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                <?php } ?>
                            </th>
                            <th class="column mobile-8 mobile-padding-top-mini" width="200" style="padding-left: 10px; padding-right: 30px; font-weight: 400;">
                                <div class="sans-serif mobile-text-left" style="color: #969AA1; font-size: 13px; line-height: 13px; text-align: right;">
                                    $<?php echo number_format((float)$item->price, 2); ?>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th class="column" colspan="3" width="640" style="padding-left: 30px; padding-right: 30px;">
                                <table class="divider" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <th height="60">
                                            <div style="border-top: 1px solid #EEEEEE; font-size: 0; line-height: 0;">&nbsp;</div>
                                        </th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </table>
                <?php } else { ?>
                    <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
                        <tr>
                            <th class="column" width="640" style="padding-left:30px; padding-right:30px; text-align:left;">
                                <div class="serif" style="color:#1F2225; font-size:18px; font-weight:700; margin-bottom:10px;">
                                    <?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                                <?php if (!empty($item->description)) { ?>
                                    <div class="sans-serif" style="color:#666; font-size:14px; line-height:22px; margin-bottom:10px;">
                                        <?php echo htmlspecialchars($item->description, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                <?php } ?>
                                <div class="sans-serif" style="color:#666; font-size:14px; line-height:22px;">Duration: <?php echo (int)$item->duration; ?> days</div>
                                <?php if ((int)$item->ilimitado_activo === 1) { ?>
                                    <div class="sans-serif" style="color:#666; font-size:14px; line-height:22px;">Audio Tokens: Unlimited</div>
                                    <div class="sans-serif" style="color:#666; font-size:14px; line-height:22px;">Video Tokens: Unlimited</div>
                                <?php } else { ?>
                                    <?php if (!empty($item->tokens)) { ?>
                                        <div class="sans-serif" style="color:#666; font-size:14px; line-height:22px;">Audio Tokens: <?php echo (int)$item->tokens; ?></div>
                                    <?php } ?>
                                    <?php if (!empty($item->tokens_video)) { ?>
                                        <div class="sans-serif" style="color:#666; font-size:14px; line-height:22px;">Video Tokens: <?php echo (int)$item->tokens_video; ?></div>
                                    <?php } ?>
                                <?php } ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="column" width="640" style="padding-left: 30px; padding-right: 30px;">
                                <table class="divider" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <th height="60">
                                            <div style="border-top: 1px solid #EEEEEE; font-size: 0; line-height: 0;">&nbsp;</div>
                                        </th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </table>
                <?php } ?>
            <?php } ?>

            <?php if (isset($cupon)) { ?>
                <table class="row" align="center" bgcolor="#FF4D4F" cellpadding="0" cellspacing="0">
                    <tr>
                        <th class="column mobile-6" width="310" style="padding:15px 10px 15px 30px; font-weight:700; color:#ffffff; text-align:left;">
                            <div class="sans-serif" style="font-size:16px;">Discount</div>
                        </th>
                        <th class="column mobile-6" width="310" style="padding:15px 30px 15px 10px; font-weight:700; color:#ffffff; text-align:right;">
                            <div class="sans-serif" style="font-size:16px;">-$<?php echo number_format((float)$orden->total_discount, 2); ?></div>
                        </th>
                    </tr>
                </table>
            <?php } ?>

            <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
                <tr>
                    <th class="column" width="640" style="padding-left: 30px; padding-right: 30px;">
                        <div class="spacer" style="font-size: 10px; line-height: 10px;">&nbsp;</div>
                        <table class="divider" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <th height="60">
                                    <div style="border-top: 1px solid #EEEEEE; font-size: 0; line-height: 0;">&nbsp;</div>
                                </th>
                            </tr>
                        </table>
                        <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
                            <tr>
                                <th class="column mobile-6" width="310" style="padding-right: 10px; font-weight: 700; color: #1F2225; text-align: left;">
                                    <div class="sans-serif" style="font-size: 16px;">Total</div>
                                </th>
                                <th class="column mobile-6" width="310" style="padding-left: 10px; font-weight: 700; color: #1F2225; text-align: right;">
                                    <div class="sans-serif" style="font-size: 16px;">$<?php echo number_format((float)$orden->total_price, 2); ?></div>
                                </th>
                            </tr>
                        </table>
                        <div class="spacer" style="font-size: 80px; line-height: 80px;">&nbsp;</div>
                    </th>
                </tr>
            </table>

            <table class="row" align="center" bgcolor="#1F2225" cellpadding="0" cellspacing="0">
                <tr>
                    <th class="column has-columns" width="640" style="padding-left: 30px; padding-right: 30px;">
                        <div class="spacer" style="font-size: 80px; line-height: 80px;">&nbsp;</div>

                        <table class="row" cellpadding="0" cellspacing="0">
                            <tr valign="top" style="vertical-align: top;">
                                <th class="column mobile-padding-bottom" width="255" style="padding-top: 10px; padding-right: 10px; text-align: left;">
                                    <a href="<?php echo $siteUrl; ?>">
                                        <img src="<?php echo $iconUrl; ?>" width="78" alt="<?php echo $siteName; ?>" style="border: 0; width: 100%; max-width: 38px;">
                                    </a>
                                </th>
                                <th class="column mobile-text-left" width="365" style="padding-left: 10px;">
                                    <table align="right" class="mobile-left" cellpadding="10" cellspacing="0">
                                        <tr>
                                            <td style="padding-left: 0;">
                                                <a href="https://facebook.com/dalemasbajo/" style="text-decoration: none;">
                                                    <img src="<?php echo $facebookIcon; ?>" width="24" alt="Facebook" style="border: 0; width: 100%; max-width: 24px;">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="https://twitter.com/dalemasbajo/" style="text-decoration: none;">
                                                    <img src="<?php echo $twitterIcon; ?>" width="24" alt="Twitter" style="border: 0; width: 100%; max-width: 24px;">
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </th>
                            </tr>
                        </table>

                        <table class="row divider" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <th height="81">
                                    <div style="border-top: 1px solid #2B2E32; font-size: 0; line-height: 0;">&nbsp;</div>
                                </th>
                            </tr>
                        </table>

                        <table class="row" cellpadding="0" cellspacing="0">
                            <tr valign="top" style="vertical-align: top;">
                                <th class="column mobile-6" width="200" style="padding-right: 10px; color: #969AA1; font-weight: 400; text-align: left;">
                                    <div class="sans-serif" style="font-size: 14px; font-weight: 700; margin-bottom: 15px;"><?php echo $siteName; ?></div>
                                </th>
                                <th class="column mobile-6" width="420" style="padding-left: 10px; font-weight: 400; text-align: left;">
                                    <div class="sans-serif" style="line-height: 100%; margin-bottom: 15px;">
                                        <a href="<?php echo $siteUrl; ?>/faq/" style="color: #969AA1; text-decoration: none;">FAQ</a>
                                    </div>
                                    <div class="sans-serif" style="line-height: 100%; margin-bottom: 15px;">
                                        <a href="<?php echo $siteUrl; ?>" style="color: #969AA1; text-decoration: none;">Visit Website</a>
                                    </div>
                                </th>
                            </tr>
                        </table>

                        <div class="spacer" style="font-size: 40px; line-height: 40px;">&nbsp;</div>

                        <table class="row" cellpadding="0" cellspacing="0">
                            <tr>
                                <th class="column" width="640" style="color: #969AA1; font-weight: 400; text-align: left;">
                                    <div class="sans-serif">
                                        &copy; <?php echo date('Y'); ?> <?php echo $siteName; ?>. All rights reserved.
                                        <a href="<?php echo $siteUrl; ?>/pages/terms_conditions/" style="color: #969AA1; text-decoration: none;">Terms &amp; Conditions</a>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td class="spacer" height="30">&nbsp;</td>
                            </tr>
                        </table>
                    </th>
                </tr>
            </table>

        </td>
    </tr>
</table>

</body>
</html>