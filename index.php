<?
 error_reporting(E_ALL);
 require_once './config.php';
 if (isset($_GET["route"])&&(!empty($_GET["route"]))){
 require_once './controller/short.php';
 $shortURL = new ControllerShort();
 try {
	$code = $shortURL->shortCodeToUrl($_GET["route"]);
	if ($code) header("Location: $code");
	else header("Location: ./index.php");
    exit;
}
catch (\Exception $e) {
    // display error screen
    $m = file_get_contents('./view/pages/error.php');
	echo $m;
    exit;
}
}

?>
<html>
<title>Test task for XIAG company</title>
<head>
<link rel='stylesheet' href='./view/stylesheet/style.css'>
<script language='javascript' src='./view/js/script.js'></script>
</head>
<body>
<div class="content" id='content'>
        <header>URL shortener</header>
        <form id='nativeForm' action='./ajax.php' method='POST'>
            <table>
                <tbody><tr>
                    <th>Long URL</th>
                    <th>Short URL</th>
                </tr>
                <tr>
                    <td>
                        <input type="url" name="url">
                        <input type="submit" value="Do!" id='formSubmit'>
                    </td>
                    <td id="result"></td>
                </tr>
            </tbody></table>
        </form>
        <footer>
            <pre>            Using this HTML please implement the following:

            1. Site-visitor (V) enters any original URL to the Input field, like
            http://anydomain/any/path/etc;
            2. V clicks submit button;
            3. Page makes AJAX-request;
            4. Short URL appears in Span element, like http://yourdomain/abCdE (don't use any
               external APIs as goo.gl etc.);
            5. V can copy short URL and repeat process with another link

            Short URL should redirect to the original link in any browser from any place and keep
            actuality forever, doesn't matter how many times application has been used after that.


            Requirements:

            1. Use PHP or Node.js;
            2. Don't use any frameworks.
                
            Expected result:

            1. Source code;
            2. System requirements and installation instructions on our platform, in English.
            </pre>

        </footer>
    </div>
</body>
</html>