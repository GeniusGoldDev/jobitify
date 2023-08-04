<?php echo $header; ?>

    <tr>
        <td align="center">
            <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="856" style="background: #ffffff; border-radius: 30px 30px 0 0;  border-top: 2px solid #eee; border-left: 2px solid #eee; border-right: 2px solid #eee;" >
                <tbody>
                    <tr>
                        <td style="vertical-align: top; padding: 0 0px;">
                            <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="font-size: 0px; padding: 40px 60px 30px; word-break: break-word;">
                                            <div>
                                                <h4 style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-weight: 700; font-size: 22px; color: #1C1C1C; line-height: 30px; margin: 0;"><?php echo nl2br($greeting); ?></h4>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>        
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center">
            <table align="center" role="presentation" border="0" cellspacing="0" cellpadding="0" width="856" style="background: #ffffff; border-left: 2px solid #eee; border-right: 2px solid #eee;">
                <tbody>
                    <tr>
                        <td style="font-size: 0px; padding: 0 60px 30px; word-break: break-word;">
                            <div>
                                <p style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; width: 100%; font-size: 16px; color: #1C1C1C; font-weight: 400; line-height: 26px; margin: 0;"><?php echo nl2br($content); ?></p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <?php if($show_button): ?>
        <tr>
            <td align="center">
                <table align="center" role="presentation" border="0" cellspacing="0" cellpadding="0" width="856" style="background: #ffffff; border-left: 2px solid #eee; border-right: 2px solid #eee;">
                    <tbody>
                        <tr>
                            <td style="font-size: 0px; padding: 0 60px 30px; word-break: break-word;">
                                <div style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size: 18px; font-weight: 700; line-height: 26px; color: #0A0F26;">
                                    <a style="display: inline-block; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size: 16px; font-weight: 700; line-height: 48px; height: 48px; color: #0A0F26; background-color: #FCCF14; padding: 0 20px; border-radius: 4px; text-align: center; text-decoration: none;"
                                        href="<?php echo e($button_url); ?>" target="_blank"><?php echo e($button_text); ?></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    <?php endif; ?>
    <?php if(!empty($signature)): ?>
        <tr>
            <td align="center">
                <table align="center" role="presentation" border="0" cellspacing="0" cellpadding="0" width="856" style="background: #ffffff; border-left: 2px solid #eee; border-right: 2px solid #eee;">
                    <tbody>
                        <tr>
                            <td style="font-size: 0px; padding: 0 60px 30px; word-break: break-word;">
                                <div>
                                    <p style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; width: 100%; font-size: 16px; color: #1C1C1C; font-weight: 400; line-height: 26px; margin: 0;"><?php echo nl2br($signature); ?></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    <?php endif; ?>
<?php echo $footer; ?>


<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/emails/template.blade.php ENDPATH**/ ?>