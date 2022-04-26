<?php

session_start();

include_once "../Lib/Func/Controller.php";
include_once "../Lib/Func/Importer.php";
include_once "../Lib/Func/Router.php";
include_once "../Lib/Func/Cap.php";
include_once "../Lib/Func/Encryption.php";
include_once "../Lib/Func/Builder.php";

Control::root(__DIR__."/..");

// XFO
// XSS
// XCTO
// XPCDP
// HSTS
// RP

header('X-Frame-Options: DENY');                                                    // Avoid page embed to frame/iframe
header('X-XSS-Protection: 1; mode=block');                                          // Avoid XSS
header('X-Content-Type-Options: nosniff');                                          // Disallow content sniffing
header("X-Permitted-Cross-Domain-Policies: none");                                  // Avoid load resource from other domain
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");  // Ensure requests from HTTPS
header("Referrer-policy: no-referrer-when-downgrade");                              // Send to higher origin

Router::Route($_SERVER["REQUEST_URI"],$_SERVER["REQUEST_METHOD"]);
?>