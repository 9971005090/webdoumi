<!DOCTYPE html>
<html>
<head>
    <title>이메일 인증</title>
</head>
<body>
<table width="100%" style="margin: 0px; padding: 0px; max-width: 600px;" border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td height="37" style="margin: 0px; padding: 0px; text-align: center; font-family: AppleSDGothicNeo-Regular,Malgun Gothic, 맑은고딕, 돋움, dotum, sans-serif;">
            <table style="margin: 0px; padding: 0px; width: 100%; font-family: AppleSDGothicNeo-Regular,Malgun Gothic, 맑은고딕, 돋움, dotum, sans-serif;" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td align="left" valign="bottom" width="112" height="37">
                        <a href="{{ url('/') }}" target="_blank" rel="noreferrer noopener">
                            <span style="color: rgb(0, 153, 255); line-height: 1; letter-spacing: -2px; font-family: AppleSDGothicNeo-Regular,Malgun Gothic, 맑은고딕, 돋움, dotum, sans-serif; font-size: 18px; font-weight: bold;">웹도우미</span>
                        </a>
                    </td>
                    <td align="left" valign="bottom" style="color: rgb(78, 78, 78); line-height: 1; letter-spacing: -2px; font-family: AppleSDGothicNeo-Regular,Malgun Gothic, 맑은고딕, 돋움, dotum, sans-serif; font-size: 18px; font-weight: bold;">이메일 인증</td><td align="right" valign="bottom" style="color: rgb(153, 153, 153); line-height: 12px; font-family: AppleSDGothicNeo-Regular,Malgun Gothic, 맑은고딕, 돋움, dotum, sans-serif; font-size: 12px;"> {{ CustomUtils::get_today('Y-m-d') }}({{ CustomUtils::get_weekday_string() }})</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td height="3" bgcolor="#465ed0"></td>
    </tr>
    <tr>
        <td>
            <table width="100%" style="margin: 0px; padding: 0px; border-right-color: rgb(230, 230, 230); border-left-color: rgb(230, 230, 230); border-right-width: 1px; border-left-width: 1px; border-right-style: solid; border-left-style: solid;" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td height="25"></td>
                </tr>
                <tr>
                    <td style="margin: 0px; padding: 0px 15px; text-align: left; color: rgb(78, 78, 78); line-height: 36px; letter-spacing: -2px; font-family: AppleSDGothicNeo-Regular,Malgun Gothic, 맑은고딕, 돋움, dotum, sans-serif; font-size: 28px;">
                        <strong style="color: rgb(70, 94, 208); display: inline-block;">안녕하세요</strong> {{$member['real_name']}}님!.
                    </td>
                </tr>
                <tr>
                    <td height="25"></td>
                </tr>
                <tr>
                    <td style="padding: 0px 15px;"> <!-- contents -->
                        <table width="100%" style="margin: 0px; padding: 0px; font-family: AppleSDGothicNeo-Regular,Malgun Gothic, 맑은고딕, 돋움, dotum, sans-serif;" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td align="left" style="padding: 0px 0px 10px; color: rgb(51, 51, 51); line-height: 16px; letter-spacing: -1px; font-family: AppleSDGothicNeo-Regular,Malgun Gothic, 맑은고딕, 돋움, dotum, sans-serif; font-size: 16px;">
                                    등록된 이메일은 {{$member['email']}}입니다. <br />아래 링크를 클릭하여 이메일 계정을 확인하세요.
                                    <br/>
                                    <a href="{{ url('/user/email_verify_confirm/'.$member->UserVerify['token']) }}">이메일 검증</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- //contents -->
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td height="1" bgcolor="#b0b0b0"></td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td style="padding: 0px; text-align: left; color: rgb(187, 187, 187); line-height: 18px; letter-spacing: -1px; font-family: Malgun Gothic, 맑은고딕, 돋움,AppleSDGothicNeo-Regular, dotum, sans-serif; font-size: 11px;">
            본 메일은 발신 전용 메일입니다. 문의는 <a href="{{ url('/') }}" name="ANCHOR33385" style="color: rgb(136, 136, 136); font-family: malgun gothic,;" target="_blank" rel="noreferrer noopener">고객센터</a>를 이용해 주세요.
        </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td height="1" bgcolor="#f4f4f4"></td>
    </tr>
    <tr>
        <td height="15"></td>
    </tr>
    <tr>
        <td>
            <table style="margin: 0px; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td style="margin: 0px; padding: 0px; text-align: left;">
                    <!--
                        <p style="margin: 0px; padding: 0px; color: rgb(169, 169, 169); line-height: 15px; letter-spacing: -1px; font-family: AppleSDGothicNeo-Regular,Malgun Gothic, 맑은고딕, 돋움, dotum, sans-serif; font-size: 11px;"> 
                            <span style="color: rgb(68, 68, 68); padding-right: 4px;">(주)사람인HR</span>&nbsp; 
                            서울시 구로구 디지털로34길 43 코오롱싸이언스밸리 1차 201호 
                            <span style="color: rgb(222, 222, 222); font-size: 10px;">|</span> 
                            고객센터 02-2025-4733 / 
                            <a href="mailto:help@saramin.co.kr" name="ANCHOR33386" style="color: rgb(169, 169, 169); text-decoration: none;" rel="noreferrer noopener" target="_blank">help@saramin.co.kr</a>
                        </p>
                    -->
                        <p style="margin: 0px; padding: 0px; color: rgb(186, 186, 186); line-height: 15px; letter-spacing: -1px; font-family: AppleSDGothicNeo-Regular,Malgun Gothic, 맑은고딕, 돋움, dotum, sans-serif; font-size: 11px;">Copyright Webdoumi Co,Ltd. All rights reserved.</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>