<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>New notification from Checkme Cloud.</title>
</head>
<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #fff">
  <tbody>
    <tr height="20px">
      <td></td>
    </tr>
    <tr>
      <td>
        <table width="700" border="0" cellspacing="0" cellpadding="0" style="text-align: left; background-color: #fff" align="center">
          <tbody>
            <tr height="20px">
              <td></td>
            </tr>
            <tr>
              <td>
                <img src="https://cloud.viatomtech.com/img/viatom-logo.png">
              </td>
              <td style="font-size: 36px; font-family: Calibri; color: #000; text-align: right; background-color: #fff"><strong>Checkme Cloud</strong></td>
            </tr>
          </tbody>
        </table>

        <table width="700" border="0" cellspacing="0" cellpadding="0" style="text-align: left; background-color: #fff" align="center">
          <tbody>
            <tr height="20px">
              <td></td>
            </tr>
            <tr>
              <td style="font-size: 20px; font-family: Calibri; color: #000000;">
                Dear {{ $user->name }}:<br>
                A patient has been shared with you. You can sign in and check it at <a href="https://cloud.viatomtech.com">Checkme Cloud</a>.
              </td>
            </tr>
            <tr height="20px">
              <td></td>
            </tr>
            <tr>
              <td style="font-size: 14px; color: #b0b0b0;">
                © 2016 Viatom Technology co., ltd <br>
                You received this because you're a registered Checkme Cloud user.
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr height="20px">
      <td></td>
    </tr>
  </tbody>
</table>

</body>
</html>
