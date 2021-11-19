# Captcha

Single Entry Point (Front controller realization)
PHP app carcase with all requests redirection to one single index.php.

Implemented with Apache and PHP. Will free to send PR's for support other servers (nginx, IIS).

Requirements
PHP version >= 7.4+
Apache 2.4
How it works
The user enters what is shown in the picture with minor interferences (lines, ellipses, dashed lines).
If what is shown in the picture is poorly visible, 
then it follows the manual further and a new captcha of better quality is generated 