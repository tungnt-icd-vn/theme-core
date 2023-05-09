<?php
  function getClientIP(){
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
            return  $_SERVER["HTTP_X_FORWARDED_FOR"];
    }else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            return $_SERVER["REMOTE_ADDR"];
    }else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
            return $_SERVER["HTTP_CLIENT_IP"];
    }
    return '';
  }
  function ipList(){
    $list = ['115.79.196.136', '127.0.0.1', '113.161.65.108',
    '34.146.39.134/32', '35.243.94.153/32', '35.243.94.153/32',
    '180.34.203.55','14.8.102.194', '120.75.92.36',
    '126.126.162.161'
    ];
    return $list ;
  }
  function whiteListIp(){
    $is_CurrentIp = getClientIP();
    $is_ListIP = ipList();
    $is_Status = in_array($is_CurrentIp, $is_ListIP);
    return $is_Status;
  }
  //Disable Or Redirect WP-login
  //add_action('init','custom_login');
  function custom_login(){
    if(ENV === 'dev'){
      if(!whiteListIp()){
        wp_redirect('https://www.cainz.co.jp/');
        exit();
      }
    };
    if(ENV === 'production' && !whiteListIp()){
      $requested_uri = $_SERVER["REQUEST_URI"];
      do_action('debugger_var_dump', $requested_uri, '$requested_uri', 0, 0);
      do_action('debugger_var_dump', strpos( $requested_uri, '/wp-login.php'), 'FOUND?', 0, 0);

      if (  strpos( $requested_uri, '/wp-login.php') !== false ) {

          do_action('debugger_var_dump', 'REDIRECT', 'REDIRECT', 0, 0);
          // The redirect codebase
          wp_redirect('https://www.cainz.co.jp/');
          die();
      }

      if (  strpos( $requested_uri, '/wp-login.php') !== false || strpos( $requested_uri, '/wp-register.php') !== false ) {

          do_action('debugger_var_dump', 'REDIRECT', 'REDIRECT', 0, 0);
          // The redirect codebase
          wp_redirect('https://www.cainz.co.jp/');
          die();
      }

      if (  strpos( $requested_uri, '/wp-admin') !== false && !is_super_admin() ) {

          do_action('debugger_var_dump', 'REDIRECT', 'REDIRECT', 0, 0);
          // The redirect codebase
          wp_redirect('https://www.cainz.co.jp/');
          die();
      }

      do_action('debugger_var_dump', 'END', 'END', 0, 0);
    };
  }
  //!Disable Or Redirect WP-login


  function add_custom_login_script() {
   ?>
    <script>
      function getUserIP(callback) {
          const xhr = new XMLHttpRequest();
          xhr.open('GET', 'https://api.ipify.org?format=json');
          xhr.onload = function() {
            if (xhr.status === 200) {
              const data = JSON.parse(xhr.responseText);
              callback(data.ip);
            } else {
              console.error('Failed to retrieve user IP');
              callback(null);
            }
          };
          xhr.onerror = function() {
            console.error('Failed to retrieve user IP');
            callback(null);
          };
          xhr.send();
      }
      const iplist = <?php echo json_encode(ipList()); ?>;
      getUserIP(function(ip) {
        console.log(ip, iplist); // logs the user's IP address to the console
        // check if the user's IP is in the iplist array
        if (iplist.indexOf(ip) !== -1) {
          console.log('IP address matched!');
          //window.location.href = "https://www.cainz.co.jp/";
          // add your own code here for when the IP address matches
        } else {
          console.log('IP address not matched!');
          window.location.href = "https://www.cainz.co.jp/";
        }
      });
    </script>
    <noscript>
      <meta http-equiv="refresh" content="0;url=https://www.cainz.co.jp/">
    </noscript>
  <?php
  }
add_action('login_enqueue_scripts', 'add_custom_login_script');
add_action( 'admin_head', 'add_custom_login_script', 1 );
add_action( 'wp_head', 'add_custom_login_script', 1 );